<template>
    <el-row>
        <el-col :span="24">
            <el-form ref="form" :model="role" :rules="role_create_rules" label-width="110px">
                <el-form-item label="角色名" prop="name">
                    <el-input v-model="role.name" placeholder="不超过 15 个字符"></el-input>
                </el-form-item>
                <el-form-item label="角色描述" prop="description">
                    <el-input v-model="role.description" placeholder="不超过 50 个字符"></el-input>
                </el-form-item>
            </el-form>
            <div class="dialog-footer fr">
                <el-button @click="cancelled">取消</el-button>
                <el-button type="primary" @click="submit">添加</el-button>
            </div>
        </el-col>
    </el-row>
</template>

<script>
    import api from '../../../api/index';

    export default {
        data() {
            return {
                role: {
                    name: '',
                    description: '',
                },
                role_create_rules: {
                    name: [
                        { required: true, message: '请输入角色名', trigger: 'blur' },
                        { max: 15, message: '角色名不能超过 15 个字符', trigger: 'blur' }
                    ],
                    description: [
                        { max: 50, message: '角色描述不能超过 50 个字符', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            reset() {
                this.role = {
                    name     : '',
                    description     : '',
                }
            },
            submit() {
                this.$refs['form'].validate( async (valid) => {
                    if (valid) {
                        let role = await api.auth.role.create(this.role);
                        this.roleCreated(role)
                    } else {
                        return false
                    }
                })
            },
            roleCreated(role){
                this.reset()
                this.$message.success('添加成功')
                this.$emit('close-form')
                this.$emit('new-role-created' , role)
            },
            cancelled(){
                this.reset()
                this.$emit('close-form')
            }
        }
    }
</script>