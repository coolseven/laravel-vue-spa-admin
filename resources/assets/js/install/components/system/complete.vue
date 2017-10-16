<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <el-col :offset="2" :span="16">
                <h1 class="title">如果您已完成系统初始化设置</h1>
                <h3 class="title">请点击下方的注销按钮</h3>
                <h3 class="title">然后使用您刚才创建的用户重新登录</h3>
                <div class="title">
                    <el-button type="primary" @click="previousStep">上一步</el-button>
                    <el-button type="success" @click="installed">注销</el-button>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import bus from '../../bus'

    export default {
        data: function () {
            return {

            }
        },
        methods: {
            previousStep(){
                bus.$emit('previous-step');
            },
            async installed() {
                try {
                    await this.$store.dispatch('logout')
                    location.replace('/login');
                } catch (error){
                    this.$message.error('退出失败！请联系开发人员!')
                }
            },
        },
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