<template>
    <el-row>
        <el-row>
            <div class="block-title">
                分配路由权限
            </div>
        </el-row>
        <el-row>
            <el-table ref="routesTable" stripe :data="guarded_routes" height="500" @selection-change="selectionChanged">
                <el-table-column type="selection"></el-table-column>
                <el-table-column prop="name" label="路由名称"></el-table-column>
                <el-table-column prop="path" label="路由地址"></el-table-column>
            </el-table>
            <div class="dialog-footer fr" style="margin-top: 20px;">
                <el-button type="primary" @click="submit">提交</el-button>
            </div>
        </el-row>
    </el-row>
</template>

<script>

    import api from "../../../api/index";
    import * as _ from "lodash";
    import {guarded_routes} from '../../../router/routes'

    export default {
        props     :{
            id:{
                required: true
            },
        },
        data(){
            return {
                guarded_routes      : [],
                role_routes         : [],
                selected_routes     : [],
            }
        },
        methods   :{
            async submit(){
                let params = { id: this.id, routes: this.selected_routes}
                await api.auth.role.modifyRoutes(params);
                this.$message.success('路由权限已更新');
                this.$emit('role-routes-modified')
            },
            selectionChanged(selected_routes){
                this.selected_routes = selected_routes;
            },
            checkRoleRoutes(role_routes,guarded_routes){
                if (role_routes && role_routes.length) {
                    guarded_routes.forEach(guarded_route => {
                        if ( _.find(role_routes,guarded_route) ) {
                            this.$nextTick(()=>{
                                this.$refs.routesTable.toggleRowSelection(guarded_route);
                            })
                        }
                    });
                }
            },
            init(){
                this.role_routes    = _.find(this.$store.state.system.roles , {id: this.id}).routes
                this.guarded_routes = guarded_routes
                this.checkRoleRoutes(this.role_routes,this.guarded_routes);
            }
        },
        mounted(){
            this.init()
        }
    }
</script>