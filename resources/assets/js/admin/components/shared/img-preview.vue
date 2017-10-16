<template>

    <!--图片预览-->
    <div class="show-image-box">
        <el-dialog v-model="isVisible">
            <div>
                <img style="width: auto" :src="url">
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import bus from '../../bus'
    export default {
        data: function(){
            return {
                isVisible: false,
                url: ''
            }
        },
        methods:{
            showImg(url){
                this.url = url;
                this.isVisible = true;
            }
        },
        mounted: function(){
            bus.$on('img-preview', this.showImg);
        }
    };
</script>

<style>
    .show-image-box .el-dialog__wrapper .el-dialog--small{width:auto}
</style>