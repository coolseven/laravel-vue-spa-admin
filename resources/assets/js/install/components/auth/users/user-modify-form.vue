<template>
    <el-row>
        <el-col :span="24">
            <el-form ref="form" :model="user" :rules="user_modify_rules" label-width="110px">
                <el-form-item v-show="false">
                    <el-input v-model="user.id" v-show="false"></el-input>
                </el-form-item>
                <el-form-item label="登录名" prop="username">
                    <el-input v-model="user.username" placeholder="不超过 15 个字符"></el-input>
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
    import * as _ from "lodash";

    export default {
        props     :{
            user_to_modify: {
                required: true
            },
            available_roles:{
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                user: {
                    id              : undefined,
                    username        : '',
                    role_names      : [],
                },
                user_modify_rules: {
                    id:[
                        { required: true, message: '获取用户的 id 失败！', trigger: 'blur' },
                    ],
                    username: [
                        { required: true, message: '请输入登录名', trigger: 'blur' },
                        { max: 15, message: '登录名不能超过 15 个字符', trigger: 'blur' }
                    ],
                    role_names: [
                        { required: true, message: '请至少选择一个所属的用户组'},
                    ],
                }
            }
        },
        methods: {
            getRoleNames(){
                return _.map(this.user.roles,role => role.name)
            },
            reset() {
                this.user = {
                    id              : undefined,
                    username        : '',
                    role_names      : [],
                }
            },
            submit() {
                this.$refs['form'].validate( async (valid) => {
                    if (valid) {
                        let role_ids = _.map(this.user.role_names,(role_name)=>{
                            return _.find(this.available_roles, {name: role_name}).id
                        })
                        let params = {
                            id               : this.user.id,
                            username         : this.user.username,
                            role_ids         : role_ids,
                        }
                        await api.auth.user.modify(params);
                        this.userModified()
                    } else {
                        return false
                    }
                })
            },
            userModified(){
                // this.reset()
                this.$message.success('编辑成功')
                this.$emit('close-form')
                this.$emit('user-modified')
            },
            cancelled(){
                // this.reset()
                this.$emit('close-form')
            },
            init(){
                this.user  = _.cloneDeep(this.user_to_modify);
                this.$set(this.user , 'role_names' , this.getRoleNames())
            }
        },
        created(){
            this.init()
        },
        watch: {
            user_to_modify(){
                this.init()
            }
        },
    }
</script>