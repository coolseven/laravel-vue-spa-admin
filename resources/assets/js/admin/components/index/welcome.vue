<template>
    <!-- Vue file -->
    <div>

        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div>
                <el-col :offset="2" :span="16">
                    <h1 class="title">欢迎来到后台管理系统</h1>
                </el-col>
            </div>
        </el-row>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {

            }
        },
        methods: {},
        created: function () {

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