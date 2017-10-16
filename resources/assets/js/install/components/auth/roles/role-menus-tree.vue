<template>
    <el-row>
        <el-col :span="11" :offset="1">
            <el-row>
                <div class="block-title">
                    分配菜单
                </div>
                <div>
                    <el-tree
                            :data="system_menus"
                            show-checkbox
                            default-expand-all
                            node-key="name"
                            ref="tree"
                            highlight-current
                            @check-change="treeChanged"
                            :props="defaultProps">
                    </el-tree>
                </div>
            </el-row>
        </el-col>

        <el-col :span="11" :offset="1">
            <el-row>
                <div class="block-title">
                    菜单预览
                </div>
                <div v-if="role_menus_for_preview.length">
                    <div>
                        <el-menu theme="dark" :collapse="false" :unique-opened="false" :router="false">
                            <template v-for="menu in role_menus_for_preview">
                                <el-menu-item v-if="menu.type === 'route'" :index="menu.path">
                                    {{menu.name}}
                                </el-menu-item>
                                <el-submenu v-if="menu.type === 'folder'" :index="menu.path">
                                    <template slot="title">
                                        {{menu.name}}
                                    </template>
                                    <el-menu-item v-for="child in menu.children" :key="child.path" :index="child.path">
                                        {{child.name}}
                                    </el-menu-item>
                                </el-submenu>
                            </template>
                        </el-menu>
                    </div>
                    <div class="dialog-footer fr" style="margin-top: 20px;">
                        <el-button type="default" @click="restore">还原</el-button>
                        <el-button type="primary" @click="submit">提交</el-button>
                    </div>
                </div>
                <div v-else>
                    <p class="text-regular">请从左侧菜单树选择角色的菜单</p>
                </div>
            </el-row>
        </el-col>

    </el-row>
</template>

<script>

    import api from "../../../api/index";
    import {mapState} from "vuex";
    import * as _ from "lodash";

    export default {
        props     :{
            id:{
                required: true
            },
        },
        data(){
            return {
                ...mapState(['system']),
                system_menus       : [],
                role_menus:[],
                role_menus_for_preview  :[],
                defaultProps       : {
                    children: 'children',
                    label: 'name'
                },
            }
        },
        methods:{
            async submit(){
                let params = { id : this.id , menus: this.role_menus_for_preview }
                await api.auth.roles.modifyMenus(params)
                this.$message.success('角色菜单已更新')
                this.$emit('role-menus-modified')
            },
            restore(){
                this.$message.info('TODO')
            },
            treeChanged(){
                let checked_keys =this.$refs.tree.getCheckedKeys()
                // Note: 如果父菜单下存在未选择的子菜单，那么 checked_keys 将不包含父节点的名称
                this.updatePreview(checked_keys)
            },
            updatePreview(flat_checked_menu_names){
                // marking
                let system_menus = _.cloneDeep(this.system_menus);
                _.each(system_menus,(menu)=>{
                    if (_.has(menu ,'children')) {
                        _.each(menu['children'],(child)=>{
                            child.selected  = (_.indexOf(flat_checked_menu_names ,child.name  ) !== -1 );
                        })
                    }
                    if (_.has(menu ,'children')) {
                        menu.selected = ( _.find(menu['children'],{selected: true}) !== undefined );
                    }else{
                        menu.selected = (_.indexOf(flat_checked_menu_names ,menu.name  ) !== -1 );
                    }
                })

                // picking
                let picked = [];
                _.each(system_menus,(menu)=>{
                    if (menu.selected) {
                        if (_.has(menu ,'children')) {
                            let selected_children = [];
                            _.each(menu['children'],(child) => {
                                child.selected && selected_children.push(child)
                            })
                            menu['children']  = selected_children
                        }
                        picked.push(menu)
                    }
                })

                this.role_menus_for_preview = picked;
            },
            computeCheckableMenuKeys(nested_role_menus){
                let checkable_menu_keys = [];
                _.each(nested_role_menus,(menu)=>{
                    if (_.has(menu,'children')) {
                        _.each(menu['children'] ,(child)=>{
                            checkable_menu_keys.push(child.name)
                        })
                    }else{
                        checkable_menu_keys.push(menu.name)
                    }
                })
                return checkable_menu_keys;
            },
            markMenuTree(nested_role_menus){
                let menu_keys_to_check = this.computeCheckableMenuKeys(nested_role_menus);
                this.$refs.tree.setCheckedKeys(menu_keys_to_check);
            },
            async getRoleMenus(){
                return _.cloneDeep(_.find(this.$store.state.system.roles , {id: this.id}).menus)
            },
            async getSystemMenus(){
                return _.cloneDeep(this.$store.state.system.menus)
            },
            async init(){
                // TODO 为什么一定要加 await 才能正常渲染 (至少一个 await)
                this.system_menus   = await this.getSystemMenus()
                this.role_menus     = await this.getRoleMenus()

                this.role_menus_for_preview = _.cloneDeep(this.role_menus);
                this.markMenuTree( this.role_menus);
            }
        },
        created(){
            this.init()
        }
    }
</script>