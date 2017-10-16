<template>
    <div>
        <el-tag class="role-tag" v-for="role in user_roles" :key="role.id" :closable="true" @close="detachRole(user_id, role)" >
            {{ role.name }}
        </el-tag>
        <span v-if="user_roles.length === 0" class="c-danger">
            待分配用户组
        </span>
    </div>
</template>

<script>
    import api from "../../../api/index";
    import * as _ from "lodash"
    export default{
        props:{
            user_id   : {
                required: true
            },
            user_roles:{
                required: true
            }
        },
        data(){
            return {
                roles  : [],
            }
        },
        methods:{
            async detachRole(user_id ,role){
                if (this.user_roles.length <= 1) {
                    const h = this.$createElement;
                    await this.$msgbox({
                        title: '警告',
                        message: h('p', null, [
                            h('span', null, '确定要退出该用户组吗? '),
                            h('br',null),h('br',null),
                            h('span', { style: 'color: #e66151' }, '用户应该至少属于某一个用户组,否则该用户将没有任何权限! '),
                        ]),
                    })
                }else{
                    await this.$confirm('确定要退出该用户组吗?','提示')
                }

                await api.auth.user.detachRole({ user_id: user_id ,role_id: role.id})

                let role_index
                for (const [index, value] of this.user_roles.entries()) {
                    if (value.id === role.id) {
                        role_index = index; break
                    }
                }
                this.user_roles.splice(role_index, 1)
            },
        },
    }
</script>


<style scoped>
    .role-tag{
        margin-right: 3px;
    }
</style>