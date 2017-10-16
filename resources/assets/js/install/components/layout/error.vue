<template>
    <!-- Vue file -->
    <div>
        <el-breadcrumb>
            <el-breadcrumb-item @click.native="$menu.change('/provider/index')">首页</el-breadcrumb-item>
            <el-breadcrumb-item>错误信息页面</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div class="block-title">
                404页面
            </div>

            <div>
                <el-col :span="12">
                    <router-link to="/demo/index"><el-button type="text">返回首页</el-button></router-link>
                    <h3>{{ error.code || '错误码'}}</h3>
                    <p>{{ error.message || '自定义错误信息'}}</p>
                </el-col>
            </div>
        </el-row>
    </div>
</template>
<script>
    export default {
        props: {
            error: {type: Object, default: function(){ return {code: 500, message: '未知错误'} }}
        },
        data: function () {
            return {}
        },
        methods: {},
        created: function () {

        }
    }
</script>