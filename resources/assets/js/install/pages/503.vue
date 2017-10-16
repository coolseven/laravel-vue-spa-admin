<template>
    <div>
        <!-- 页面内容部分 -->
        <div class="app-error">

            <el-row>
                <el-col :offset="10" :span="4">
                    <p class="message">Relax. We Will Be Right Back</p>
                </el-col>
            </el-row>

            <el-row>
                <el-col :offset="10" :span="4">
                    <p class="route">
                        <el-button type="text" @click="backToHome">回到首页</el-button>
                        <span style="margin-right: 30px;"></span>
                        <el-button type="text" @click="backToLast">回到上一页</el-button>
                    </p>
                </el-col>
            </el-row>

        </div>
    </div>

</template>

<script>
    export default {
        methods:{
            backToHome(){
                this.$router.replace('/');
            },
            backToLast(){
                this.$router.go(-1);
            }
        }
    }
</script>

<style scoped>
    div.app-error{
        background: #f1f2f7;
        position: fixed;
        height:100%;
        width:100%;
        right: 0;
        top: 0;
        bottom: 0;
        overflow: hidden;
    }
    div p.message{
        margin-top: 400px;
        text-align: center;
        font-size: 50px;
    }
    div p.route{
        margin: 20px;
        text-align: center;
        color: #475669;
    }
</style>