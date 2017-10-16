<template>
    <div>
        <!-- 页面路径 -->
        <el-breadcrumb class="p-b-10">
            <el-breadcrumb-item>
                <router-link to="/index">首页</router-link>
            </el-breadcrumb-item>
            <el-breadcrumb-item>网络请求示例</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- 页面内容部分 -->
        <el-row class="page-content" >
            <div class="page-title">
                网络请求示例
            </div>
            <el-row :gutter="25">
                <el-col>
                    <el-card>
                        <h2>{{ reply }}</h2>
                    </el-card>
                </el-col>
            </el-row>

        </el-row>
    </div>
</template>
<style>
</style>
<script>
    import api from '../../api';

    export default {
        data: function () {
            return {
                reply: 'ping...'
            }
        },
        methods: {
            async ping(){
                this.reply = await api.example.ping();
            }
        },
        created: function () {
            setTimeout( this.ping, 1000);
        }
    }
</script>