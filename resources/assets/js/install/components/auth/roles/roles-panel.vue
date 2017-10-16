<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row>
            <!-- 标题和右侧的添加按钮-->
            <el-row style="margin-bottom: 20px;">
                <div class="block-title">
                    角色管理
                </div>
                <div class="fr" style="margin-top: 5px;">
                    <el-button type="success" @click="is_role_create_dialog_visible = true">添加角色</el-button>
                </div>
            </el-row>

            <el-row>
                <el-tabs v-model="current_role_name" type="card" editable @edit="roleTabsChanged">
                    <el-tab-pane v-for="role in roles" :key="role.id" :label="role.name" :name="role.name">
                        <el-row>
                            <el-col :span="3">
                                <role-users-table :id="role.id"></role-users-table>
                            </el-col>

                            <el-col :span="5" :offset="1">
                                <role-menus-tree :id="role.id" @role-menus-modified="roleMenusModified"></role-menus-tree>
                            </el-col>

                            <el-col :span="7" :offset="1">
                                <role-apis-table :id="role.id" @role-apis-modified="roleApisModified"></role-apis-table>
                            </el-col>

                            <el-col :span="6" :offset="1">
                                <role-routes-table :id="role.id" @role-routes-modified="roleRoutesModified"></role-routes-table>
                            </el-col>
                        </el-row>

                    </el-tab-pane>
                </el-tabs>
            </el-row>

        </el-row>

        <el-row style="margin-top: 20px;">
            <div class="fr">
                <el-button type="primary" @click="previousStep">上一步</el-button>
                <el-button type="success" @click="nextStep">下一步</el-button>
            </div>
        </el-row>

        <el-dialog size="tiny" title='添加角色' :visible.sync="is_role_create_dialog_visible">
            <role-create-form @new-role-created="newRoleCreated" @close-form="is_role_create_dialog_visible = false"></role-create-form>
        </el-dialog>

        <el-dialog>
            <role-modify-form></role-modify-form>
        </el-dialog>

    </div>
</template>

<script>
    import api from '../../../api/index';
    import bus from '../../../bus'
    import * as _ from "lodash";
    import RoleBasicInfoTable from './role-basic-info-table.vue'
    import RoleUsersTable from './role-users-table.vue'
    import RoleMenusTree from './role-menus-tree.vue'
    import RoleApisTable from './role-apis-table.vue'
    import RoleRoutesTable from './role-routes-table.vue'
    import RoleCreateForm from './role-create-form.vue'
    import RoleModifyForm from './role-modify-form.vue'

    export default {
        components:{
            RoleBasicInfoTable,RoleUsersTable,RoleCreateForm,RoleModifyForm,RoleMenusTree,RoleApisTable,RoleRoutesTable
        },
        data() {
            return {
                roles: [],
                current_role_name: '',
                is_role_create_dialog_visible: false,
            }
        },
        methods: {
            nextStep(){
                bus.$emit('next-step');
            },
            previousStep(){
                bus.$emit('previous-step');
            },
            onRefresh(target){
                this.init();
            },
            newRoleCreated(new_role){
                this.is_role_create_dialog_visible = false
                this.roles.push(new_role)
                this.current_role_name = new_role.name
                this.$store.dispatch('sync')
            },
            roleMenusModified(){
                this.$store.dispatch('sync')
            },
            roleApisModified(){
                this.$store.dispatch('sync')
            },
            roleRoutesModified(){
                this.$store.dispatch('sync')
            },
            async roleTabsChanged(target_role_name, action){
                if (action === 'add') {
                    this.is_role_create_dialog_visible = true
                }
                if (action === 'remove') {
                    let role = _.find(this.roles , {name : target_role_name});
                    let role_index = _.findIndex(this.roles , {name : target_role_name});

                    await this.$confirm('此操作将永久删除该角色, 是否继续?', '警告');
                    await api.auth.role.remove({id: role.id})
                    this.$store.dispatch('sync')

                    this.$message.success('删除成功!');
                    this.roles = _.without(this.roles, role);

                    let candidate_role = this.roles[role_index + 1] || this.roles[role_index - 1]
                    if (candidate_role) {
                        this.current_role_name = candidate_role.name
                    }
                }
            },
            init(){
                this.roles = _.cloneDeep(this.$store.state.system.roles)
                this.current_role_name = _.first(this.roles).name;
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
