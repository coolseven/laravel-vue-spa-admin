<template>
    <el-row>
        <el-row>
            <div class="block-title">
                分配接口权限
            </div>
        </el-row>
        <el-row>
            <el-table ref="apisTable" stripe :data="system_apis" height="500" @selection-change="selectionChanged">
                <el-table-column type="selection"></el-table-column>
                <el-table-column prop="description" label="接口名称"></el-table-column>
                <el-table-column prop="uri"         label="接口地址"></el-table-column>
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

    export default {
        props     :{
            id:{
                required: true
            },
        },
        data(){
            return {
                system_apis       : [],
                role_apis         : [],
                selected_apis     : [],
            }
        },
        methods   :{
            async submit(){
                let params = { id: this.id, apis: this.selected_apis}
                await api.auth.role.modifyApis(params);
                this.$message.success('角色接口权限已更新');
                this.$emit('role-apis-modified')
            },
            selectionChanged(selected_apis){
                this.selected_apis = selected_apis;
            },
            updateSelectedApis(role_apis,system_apis){
                if (role_apis.length) {
                    system_apis.forEach(system_api => {
                        if (_.find(role_apis,system_api)) {
                            this.$refs.apisTable.toggleRowSelection(system_api);
                        }
                    });
                }
            },
            async getRoleApis(){
                return await _.cloneDeep(_.find(this.$store.state.system.roles , {id: this.id}).apis )
            },
            async getSystemApis(){
                return await _.cloneDeep(this.$store.state.system.apis)
            },
            async init(){
                this.system_apis = await this.getSystemApis()
                this.role_apis   = await this.getRoleApis()
                this.updateSelectedApis(this.role_apis,this.system_apis);
            }
        },
        created(){
            this.init()
        }
    }
</script>
