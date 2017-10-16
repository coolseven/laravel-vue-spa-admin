<template>
    <!-- Vue file -->
    <div>

        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div>
                <el-col :offset="2" :span="16">
                    <h1 class="title">您正在进行系统的初始化设置,请根据左侧的引导进行各项初始化操作</h1>
                    <div class="title">
                        <el-button type="success" @click="nextStep">开始</el-button>
                    </div>
                </el-col>
            </div>
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
            nextStep(){
                bus.$emit('next-step');
            }
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