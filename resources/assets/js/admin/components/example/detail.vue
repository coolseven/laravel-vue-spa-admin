<template>
    <div>
        <!-- 页面路径 -->
        <el-breadcrumb class="p-b-10">
            <el-breadcrumb-item @click.native="$menu.change('/demo/index')">首页</el-breadcrumb-item>
            <el-breadcrumb-item @click.native="$menu.change('/demo/list')">示例模块</el-breadcrumb-item>
            <el-breadcrumb-item>详情页</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div class="block-title">
                示例详情页
            </div>

            <el-col>
                <el-col :span="12">
                    <el-form :inline="true" class="form_detail" label-position="left" label-width="120px">
                        <el-form-item label="名称dsafs">
                            嗷嗷嗷
                        </el-form-item>
                        <el-form-item label="名称">
                            嗷嗷嗷
                        </el-form-item>
                        <el-form-item label="名称">
                            嗷嗷嗷
                        </el-form-item>
                        <el-form-item label="名称">
                            嗷嗷嗷
                        </el-form-item>
                    </el-form>
                </el-col>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import { quillEditor } from 'vue-quill-editor';
    export default {
        data: function () {
            return {

            }
        },
        methods: {

        },
        created: function () {

        }
    }
</script>