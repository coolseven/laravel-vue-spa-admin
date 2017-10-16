<template>
    <el-row>
        <el-col :span="24">
            <el-form ref="form" :model="user" :rules="user_create_rules" label-width="110px">
                <el-form-item label="登录名" prop="username">
                    <el-input v-model="user.username" placeholder="不超过 15 个字符"></el-input>
                </el-form-item>
                <el-form-item label="登录密码" prop="password">
                    <el-input v-model="user.password" placeholder="不超过 15 个字符"></el-input>
                </el-form-item>
                <el-form-item label="所属角色" prop="role_names">
                    <el-select v-model="user.role_names" multiple placeholder="请选择">
                        <el-option
                                v-for="role in available_roles"
                                :key="role.id"
                                :label="role.name"
                                :value="role.name">
                        </el-option>
                    </el-select>
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
    import * as _ from "lodash"

    export default {
        props:{
            available_roles:{
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                user: {
                    username: '',
                    password: '',
                    role_names:[],
                },
                user_create_rules: {
                    username: [
                        { required: true, message: '请输入登录名', trigger: 'blur' },
                        { max: 15, message: '登录名不能超过 15 个字符', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入登录密码'},
                        { max: 15, message: '登录密码不能超过 15 个字符', trigger: 'blur' }
                    ],
                    role_names: [
                        { required: true, message: '用户至少属于一个角色'},
                    ],
                }
            }
        },
        methods: {
            reset() {
                this.user = {
                    username     : '',
                    password     : '',
                    role_names   : [],
                }
            },
            submit() {
                this.$refs['form'].validate( async (valid) => {
                    if (valid) {
                        let role_ids = _.map(this.user.role_names,(role_name)=>{
                            return _.find(this.available_roles, {name: role_name}).id
                        })
                        let params = {
                            username         : this.user.username,
                            password         : this.user.password,
                            role_ids         : role_ids,
                        }
                        await api.auth.user.create(params);
                        this.userCreated()
                    } else {
                        return false
                    }
                })
            },
            userCreated(){
                this.reset()
                this.$message.success('添加成功')
                this.$emit('close-form')
                this.$emit('new-user-created')
            },
            cancelled(){
                this.reset()
                this.$emit('close-form')
            }
        }
    }
</script>