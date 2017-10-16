<template>
    <el-row>
        <el-col :span="24">
            <el-form ref="form" :model="menu" :rules="menu_create_rules" label-width="110px">

                <el-form-item  label="菜单类型"  prop="type">
                    <el-select v-model="menu.type" size="small" placeholder="请选择菜单类型" @change="menuTypeSelected">
                        <el-option label="菜单组" value="folder"></el-option>
                        <el-option label="菜单" value="route"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="上级菜单">
                    <el-select v-model="menu.parent" size="small" placeholder="请选择所属的上级菜单"  :disabled="menu.type === 'folder'">
                        <el-option v-for="(folder_name,index) in folder_names" :key="index" :label="folder_name" :value="folder_name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item  label="目标路由"  v-show="menu.type === 'route'">
                    <el-select v-model="menu.path" size="small" placeholder="请选择目标路由" @change="routeSelected">
                        <el-option v-for="route in routes" :key="route.path" :label="route.name" :value="route.path"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="菜单名称" prop="name">
                    <el-input v-model="menu.name" placeholder="不超过 15 个字符" :disabled="menu.type === 'route'"></el-input>
                </el-form-item>
            </el-form>
            <div class="dialog-footer fr">
                <el-button @click="cancelled">取消</el-button>
                <el-button type="primary" @click="submit">确定</el-button>
            </div>
        </el-col>
    </el-row>
</template>

<script>
    import api from '../../../api/index';
    import * as _ from "lodash";

    export default {
        props:{
            available_routes : {
                type : Array,
                required: true,
            },
            available_menu_folder_names: {
                type : Array,
                required: true,
            }
        },
        data() {
            return {
                routes: [],
                folder_names: [],
                menu: {
                    name: '',
                    type: '',
                    path: '',
                    parent: '',
                },
                menu_create_rules: {
                    name: [
                        { required: true, message: '请选择或填写菜单名称'},
                    ],
                    type: [
                        { required: true, message: '请选择菜单类型'},
                    ],
                }
            }
        },
        methods: {
            reset(menu) {
                this.menu = {
                    name: '',
                    type: '',
                    path: '',
                    parent:  '',
                }
            },
            submit() {
                this.$refs['form'].validate( async (valid) => {
                    if (valid) {
                        this.menuCreated(this.menu)
                    } else {
                       // TODO
                    }
                })
            },
            menuCreated(menu){
                this.reset(menu)
                this.$emit('new-menu-created' , menu)
            },
            routeSelected(path){
                if (path) {
                    this.menu.name = this.getRouteNameByRoutePath(path);
                }
            },
            menuTypeSelected(type){
                if (type === 'folder') {
                    this.menu.parent = '根菜单'
                }
            },
            getRouteNameByRoutePath(path){
                let route = _.find(this.available_routes , {'path' : path});
                return route.name;
            },
            cancelled(){
                this.reset()
            },
        },
        created(){
            this.routes  = _.cloneDeep(this.available_routes);
            this.folder_names = _.cloneDeep(this.available_menu_folder_names);
        },
        watch:{
            available_routes(){
                this.routes  = _.cloneDeep(this.available_routes);
            },
            available_menu_folder_names(){
                this.folder_names = _.cloneDeep(this.available_menu_folder_names);

                // THIS IS A HACK. TODO
                if (! _.some(this.folder_names , this.menu.parent)) {
                    this.reset();
                }
            }
        }
    }
</script>