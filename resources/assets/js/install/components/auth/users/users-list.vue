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
                    <el-button type="success" @click="isAddDialogVisible = true">添加用户</el-button>
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
                        <el-button type="text" @click="$message.info('todo')">查看接口列表</el-button>
                        <el-button type="text" @click="$message.info('todo')">预览菜单</el-button>
                        <el-button type="text" @click="modifyUser(scope.row)">编辑</el-button>
                        <el-button type="text" class="c-danger" @click="deleteUser(scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>

            <!-- 分页 -->
            <el-pagination class="fr m-t-20" layout="total, prev, pager, next"
                    :current-page.sync="searchParams.page"
                    @current-change="pageChanged"
                    :page-size="searchParams.pageSize"
                    :total="total"
            ></el-pagination>
        </el-row>

        <el-row style="margin-top: 20px;">
            <div class="fr">
                <el-button type="primary" @click="previousStep">上一步</el-button>
                <el-button type="success" @click="nextStep">下一步</el-button>
            </div>
        </el-row>

        <!-- 添加表单 -->
        <el-dialog title="添加用户" :visible.sync="isAddDialogVisible" size="tiny">
            <user-create-form :available_roles="roles" @close-form="isAddDialogVisible = false" @new-user-created="newUserCreated"></user-create-form>
        </el-dialog>

        <!-- 编辑表单 -->
        <el-dialog title="编辑用户" :visible.sync="isEditDialogVisible" size="tiny">
            <user-modify-form  :available_roles="roles" @close-form="isEditDialogVisible = false" @user-modified="userModified" :user_to_modify="userToModify"></user-modify-form>
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
                searchParams: {
                    page: 1,
                    pageSize: 15,
                },
                total: 0,
                users: [],
                roles:[],
                isAddDialogVisible  : false,
                isEditDialogVisible : false,
                userToModify: null,
            }
        },
        methods: {
            nextStep(){
                bus.$emit('next-step');
            },
            previousStep(){
                bus.$emit('previous-step');
            },
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
                this.paginate({page: this.searchParams.page})
            },
            userModified(){
                this.$store.dispatch('sync')
                this.paginate({page: this.searchParams.page})
            },
            modifyUser(user){
                this.userToModify = user;
                this.isEditDialogVisible = true;
            },
            pageChanged(currentPage){   // 翻页
                let params = {page: currentPage};
                this.paginate(params);
            },
            resetSearchParams(){
                this.searchParams.page = 1;
                this.searchParams.pageSize = 15;
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
                this.roles = _.cloneDeep(this.$store.state.system.roles)
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
