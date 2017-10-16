<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div class="page-title">
                首页
            </div>

            <div>
                <el-col :offset="2" :span="16">
                    <h1 class="title">This is an example</h1>
                    <h2 class="title">you are at {{ routePath }}</h2>
                    <el-button @click="test">访问角色管理页</el-button>
                </el-col>
            </div>
        </el-row>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                routePath : ''
            }
        },
        methods:{
            test(){
                this.$router.push('/auth/roles')
            }
        },
        created: function () {
            this.routePath = this.$route.fullPath
        }
    }
</script>
<style scoped>
    .title {
        margin: 20px;
        text-align: center;
        color: #475669;
    }
</style>