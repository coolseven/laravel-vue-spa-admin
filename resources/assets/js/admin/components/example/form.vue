<template>
    <div>
        <!-- 页面路径 -->
        <el-breadcrumb class="p-b-10">
            <el-breadcrumb-item>
                <router-link to="/index">首页</router-link>
            </el-breadcrumb-item>
            <el-breadcrumb-item>表单页</el-breadcrumb-item>
        </el-breadcrumb>

        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div class="block-title">
                示例表单页
            </div>

            <el-col>
                <el-col :span="12">
                    <el-form :model="form" label-width="100px">
                        <el-form-item label="名称">
                            <el-input v-model="form.name"></el-input>
                        </el-form-item>
                        <el-form-item label="起始时间">
                            <el-date-picker v-model="form.startDate"></el-date-picker>
                             -
                            <el-date-picker v-model="form.endDate"></el-date-picker>
                        </el-form-item>
                        <el-form-item label="多行文本框">
                            <el-input type="textarea" v-model="form.desc"></el-input>
                        </el-form-item>
                        <el-form-item label="富文本">
                            <quill-editor ref="myTextEditor" v-model="form.content" :config="editorOption"></quill-editor>
                        </el-form-item>
                    </el-form>
                    <div class="form-footer">
                        <el-button>取消</el-button>
                        <el-button @click="submit" type="primary">提交</el-button>
                    </div>
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
                form: {
                    name: '',
                    startDate: '',
                    endDate: '',
                    desc: '',
                    content: '',
                },
                editorOption: {
                    placeholder: 'Compose an epic...',
                    theme: 'snow'
                }
            }
        },
        methods: {
            submit(){
                console.log('form数据', this.form);
            }
        },
        created: function () {

        },
        components: {
            quillEditor
        }
    }
</script>