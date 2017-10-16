<template>
    <div>
        <el-row>
            <div class="block-title">用户管理</div>
        </el-row>
        <el-row>
            <el-table stripe :data="users">
                <el-table-column label="用户名" prop="username"></el-table-column>
                <el-table-column label="操作">
                    <template scope="scope">
                        <el-button type="text" @click="detachUser(scope.row)">移出</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <div class="dialog-footer fr" style="margin-top: 20px;">
                <el-button type="primary" @click="attachUser">选择用户</el-button>
            </div>
        </el-row>
    </div>
</template>

<script>
    import api from "../../../api/index"
    import * as _ from "lodash"

    export default {

        props     :{
            id:{
                required: true
            }
        },
        data(){
            return {
                users: [],
            }
        },
        methods   :{
            attachUser(){
                this.$message.info('TODO')
            },
            async detachUser(user){
                let yes = await this.$confirm('确定要将该用户移出该组吗?','提示');
                if (yes) {
                    let params = {
                        role_id: this.id,
                        user_id: user.id,
                    }
                    await api.auth.role.detachUser(params)
                    this.users = _.without(this.users,user)
                    this.$message.success('该用户已从组中移出')
                }
            },
            getRoleUsers(){
                return api.auth.role.users({id: this.id});
            },
            async init(){
                this.users = await this.getRoleUsers();
            }
        },
        created(){
            this.init();
        }
    }
</script>