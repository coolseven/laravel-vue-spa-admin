<template>
    <div>
        <el-row>
            <div class="block-title">基础信息</div>
        </el-row>
        <el-row>
            <div>

            </div>
        </el-row>
    </div>
</template>

<script>
    import api from "../../../api/index"

    export default {

        props     :{
            id:{
                required: true
            }
        },
        data(){
            return {
                role: {},
            }
        },
        methods   :{
            getRoleBasicInfo(){
                return api.auth.role.basic({id: this.id});
            },
            async init(){
                this.role = await this.getRoleBasicInfo();
            }
        },
        created(){
            this.init();
        }
    }
</script>