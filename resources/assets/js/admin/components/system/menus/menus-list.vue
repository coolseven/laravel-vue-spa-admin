<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row class="page-content">

            <el-col :span="5">
                <el-row>
                    <div class="block-title">
                        添加菜单
                    </div>
                    <div>
                        <menu-create-form :available_routes="un_selected_routes" :available_menu_folder_names="available_menu_folder_names" @new-menu-created="newMenuCreated"></menu-create-form>
                    </div>
                </el-row>
            </el-col>

            <el-col :span="5" :offset="2">
                <el-row>
                    <div class="block-title">
                        菜单预览
                    </div>
                    <div>
                        <menus-preview :menus_to_preview="system_menus_for_preview" @reset="previewReset" @restore="previewRestore"></menus-preview>
                    </div>
                </el-row>
            </el-col>

        </el-row>

    </div>
</template>
<script>
    import api from '../../../api/index';
    import bus from '../../../bus'
    import * as _ from "lodash";

    import {menu_able_routes} from '../../../router/routes'

    import MenuCreateForm from './menu-create-form.vue'
    import MenusPreview from './menus-preview.vue'

    export default {
        components:{
            MenuCreateForm,MenusPreview
        },
        data() {
            return {
                system_menus_for_preview: [],
                available_menu_folder_names: ["根菜单"],
                un_selected_routes      : [],
            }
        },
        methods: {
            onRefresh(target){

            },
            previewReset(){
                this.renderWith([]);
            },
            previewRestore(){
                this.init()
            },
            newMenuCreated(new_menu){
                this.addNewMenuToMenuPreview(new_menu);
                this.addAvailableFolderName(new_menu);
                this.removeRouteFromUnSelectedRoutes(new_menu);
            },
            addNewMenuToMenuPreview(new_menu){
                if (new_menu.type === 'folder') {
                    if (new_menu.parent === '根菜单') {
                        this.system_menus_for_preview.push(new_menu)
                    }
                }

                if(new_menu.type === 'route'){
                    if (new_menu.parent === '根菜单') {
                        this.system_menus_for_preview.push(new_menu)
                    }else{
                        _.map(this.system_menus_for_preview , (menu) => {
                            if (menu.type === 'folder' && menu.name === new_menu.parent) {
                                if (_.has(menu,'children') ) {
                                    menu.children.push(new_menu)
                                }else{
                                    this.$set(menu,'children' , [ new_menu ])  // 备注： 不能直接用 this.menu.children = [ new_menu ] !!!!
                                }
                            }
                        })
                    }
                }
            },
            addAvailableFolderName(new_menu){
                if (new_menu.type === 'folder') {
                    this.available_menu_folder_names.push(new_menu.name)
                }
            },
            removeRouteFromUnSelectedRoutes(new_menu){
                if (new_menu.type === 'route') {
                    this.un_selected_routes = _.filter(this.un_selected_routes , (route)=>{
                        return route.path !== new_menu.path
                    })
                }
            },
            filterUnSelectedRoutes(current_system_menus_flattened,menu_able_routes){
                return _.filter(menu_able_routes,(route) => {
                    return (!_.find(current_system_menus_flattened , {path : route['path']} ))
                })
            },
            getCurrentMenuFolderNames(current_system_menus_flattened){
                let current_menu_folder_names = ["根菜单"];
                _.each(current_system_menus_flattened,(menu)=>{
                    if (menu.type === 'folder' && menu.name !== '根菜单') {
                        current_menu_folder_names.push(menu.name)
                    }
                })
                return _.uniq(current_menu_folder_names);
            },
            getFlattenedSystemMenus(nested_menus){
                let flat_menus = [];
                _.each(nested_menus ,(menu)=>{
                    flat_menus.push({
                        name: menu.name, type: menu.type, path: menu.path, parent: menu.parent,
                    })
                    if (_.has(menu,'children')){
                        _.each(menu['children'],(child_menu)=>{
                            flat_menus.push(child_menu)
                        })
                    }
                })
                return flat_menus;
            },
            renderWith(current_system_menus_nested){
                let current_system_menus_flattened  = this.getFlattenedSystemMenus(current_system_menus_nested);

                this.un_selected_routes          = this.filterUnSelectedRoutes(current_system_menus_flattened, menu_able_routes);
                this.available_menu_folder_names = this.getCurrentMenuFolderNames(current_system_menus_flattened);
                this.system_menus_for_preview    = current_system_menus_nested;
            },
            init(){
                // 当前已创建的系统菜单
                let current_system_menus_nested = this.$store.state.system.menus
                this.renderWith(current_system_menus_nested);
            }
        },
        mounted(){
            bus.$on('refresh-route', this.onRefresh);
        },
        created: function () {
            this.init();
        }
    }
</script>
