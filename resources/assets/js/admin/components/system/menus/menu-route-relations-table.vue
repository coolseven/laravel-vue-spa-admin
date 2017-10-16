<template>
    <!-- Vue file -->
    <div>
        <el-table stripe :data="routes">
            <el-table-column label="已关联菜单" prop="in_menu" max-width="10px">
                <template scope="scope">
                    <i class="el-icon-check" v-if="routeHasRelatedMenu(scope.row)"></i>
                </template>
            </el-table-column>
            <el-table-column label="路由名称" prop="name"></el-table-column>
            <el-table-column label="访问路径">
                <template scope="scope">
                    <router-link :to="{path : scope.row.path}">
                        <span style="color:#20a0ff;">{{ scope.row.path }}</span>
                    </router-link>
                </template>
            </el-table-column>
            <el-table-column label="描述" prop="description"></el-table-column>
        </el-table>
    </div>
</template>
<script>

    import * as _ from "lodash";

    export default {
        props     :{
            route_menu_relations: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                routes: [],
            }
        },
        methods   : {
            routeHasRelatedMenu(route){
                return _.has(route, 'hasRelatedMenu');
            }
        },
        created   : function () {
            this.routes = _.cloneDeep(this.route_menu_relations);
        },
        watch     :{
            route_menu_relations: {
                handler: function(new_route_menu_relations){
                    this.routes = _.cloneDeep(new_route_menu_relations);
                },
                deep: true,
            }
        }
    }
</script>
