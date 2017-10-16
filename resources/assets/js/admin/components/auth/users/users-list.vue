<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <!-- 标题和右侧的添加按钮-->
            <el-row style="margin-bottom: 20px;">
                <div class="block-title">
                    用户管理
                </div>
                <div class="fr" style="margin-top: 5px;">
                    <el-button type="success" @click="add_dialog_visible = true">添加用户</el-button>
                </div>
            </el-row>

            <!-- 列表栏 -->
            <el-table stripe :data="users">
                <el-table-column label="用户名" prop="username"></el-table-column>
                <el-table-column label="所属的角色">
                    <template scope="scope">
                        <user-role-tags :user_id="scope.row.id" :user_roles="scope.row.roles"></user-role-tags>
                    </template>
                </el-table-column>
                <el-table-column label="操作">
                    <template scope="scope">
                        <el-button type="text" @click="$message.info('todo')">预览用户菜单</el-button>
                        <el-button type="text" @click="modifyUser(scope.row)">编辑</el-button>
                        <el-button type="text" class="c-danger" @click="deleteUser(scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>

            <!-- 分页 -->
            <el-pagination class="fr m-t-20" layout="total, prev, pager, next"
                    :current-page.sync="search.page"
                    @current-change="pageChanged"
                    :page-size="search.pageSize"
                    :total="total"
            ></el-pagination>
        </el-row>

        <!-- 添加表单 -->
        <el-dialog title="添加用户" :visible.sync="add_dialog_visible" size="tiny">
            <user-create-form :available_roles="roles" @close-form="add_dialog_visible = false" @new-user-created="newUserCreated"></user-create-form>
        </el-dialog>

        <!-- 编辑表单 -->
        <el-dialog title="编辑用户" :visible.sync="edit_dialog_visible" size="tiny">
            <user-modify-form  :available_roles="roles" @close-form="edit_dialog_visible = false" @user-modified="userModified" :user_to_modify="user_to_modify"></user-modify-form>
        </el-dialog>
    </div>
</template>
<script>
    import api from '../../../api/index';
    import bus from '../../../bus'
    import UserRoleTags from './../shared/user-role-tags.vue'
    import UserCreateForm from './user-create-form.vue'
    import UserModifyForm from './user-modify-form.vue'
    import * as _ from "lodash";

    export default {
        components:{
            UserRoleTags , UserCreateForm ,UserModifyForm
        },
        data: function () {
            return {
                search: {
                    page: 1,
                    pageSize: 15,
                },
                total: 0,
                users: [],
                roles:[],
                add_dialog_visible  : false,
                edit_dialog_visible : false,
                user_to_modify: null,
            }
        },
        methods: {
            async deleteUser(user){  // 删除用户
                await this.$confirm('此操作将永久删除该用户, 是否继续?', '提示')
                await api.auth.user.remove({id: user.id})
                this.userDeleted(user)
            },
            userDeleted(user){
                this.$store.dispatch('sync')
                this.$message.success('删除成功!');
                this.users = _.without(this.users , user);
            },
            newUserCreated(){
                this.$store.dispatch('sync')
                this.paginate({page: this.search.page})
            },
            userModified(){
                this.$store.dispatch('sync')
                this.paginate({page: this.search.page})
            },
            modifyUser(user){
                this.user_to_modify = user;
                this.edit_dialog_visible = true;
            },
            pageChanged(currentPage){   // 翻页
                let params = {page: currentPage};
                this.paginate(params);
            },
            resetSearchParams(){
                this.search.page = 1;
                this.search.pageSize = 15;
            },
            async paginate(params){
                params = params || {page:1}
                let data = await api.auth.users.paginate(params)

                this.users   = data.data;
                this.total   = data.total;
            },
            onRefresh(target){
                this.paginate();
            },
            init(){
                this.roles = this.$store.state.system.roles
                this.paginate();
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
