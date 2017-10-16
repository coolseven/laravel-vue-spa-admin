<template>
    <!-- Vue file -->
    <div>
        <!-- 页面内容部分 -->
        <el-row class="page-content">
            <div class="block-title">
                示例列表
                {{reply}
            </div>

            <!-- 搜索栏 -->
            <el-col>
                <el-form class="search-form fl" :inline="true" :model="searchForm">
                    <el-form-item>
                        <el-form-item>
                            <el-select v-model="searchForm.key" size="small" placeholder="请选择搜索项">
                                <el-option label="名称" value="name"></el-option>
                                <el-option label="描述" value="desc"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item>
                            <el-input v-model="searchForm.keyword" size="small" placeholder="请输入关键字"></el-input>
                        </el-form-item>
                    </el-form-item>
                    <el-form-item label="状态：">
                        <el-select v-model="searchForm.status" size="small">
                            <el-option label="全部" value=""></el-option>
                            <el-option label="启用" value="1"></el-option>
                            <el-option label="禁用" value="2"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" size="small" @click="search">搜索</el-button>
                    </el-form-item>
                </el-form>
                <!-- 右侧添加按钮 -->
                <div class="fr">
                    <el-button @click="example">example</el-button>
                    <el-button @click="exportData">导出数据</el-button>
                    <el-button type="success" @click="add">添加数据</el-button>
                </div>
            </el-col>

            <!-- 列表栏 -->
            <el-col>
                <el-table stripe :data="list" @selection-change="selectionChange">
                    <el-table-column type="selection"></el-table-column>
                    <el-table-column prop="name" label="名称"></el-table-column>
                    <el-table-column prop="desc" label="描述"></el-table-column>
                    <el-table-column prop="type" label="类型"></el-table-column>
                    <el-table-column label="状态">
                        <template scope="scope">
                            <span v-if="scope.row.status == 1" class="c-green">已启用</span>
                            <span v-else class="c-gray">已禁用</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="操作">
                        <template scope="scope">
                            <el-button type="text" @click="changeStatus(scope.row)">{{scope.row.status == 1 ? '禁用' : '启用'}}</el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <!-- 表格底部 -->
                <el-col class="m-t-20">
                    <!-- 批量操作 -->
                    <div class="fl">
                        <el-button type="success" size="small" @click="batchEnable">批量启用</el-button>
                        <el-button type="danger" size="small" @click="batchDisable">批量禁用</el-button>
                        <el-dropdown menu-align="start" @command="moreMenuClick">
                            <el-button size="small" type="primary">
                                更多 <i class="el-icon-more el-icon--right"></i>
                            </el-button>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item command="a">黄金糕</el-dropdown-item>
                                <el-dropdown-item command="b">狮子头</el-dropdown-item>
                                <el-dropdown-item command="c">螺蛳粉</el-dropdown-item>
                                <el-dropdown-item command="d" disabled>双皮奶</el-dropdown-item>
                                <el-dropdown-item command="e" divided>蚵仔煎</el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </div>
                    <!-- 分页 -->
                    <el-pagination
                            class="fr"
                            layout="total, prev, pager, next"
                            :current-page.sync="searchForm.page"
                            @current-change="changePage"
                            :page-size="searchForm.pageSize"
                            :total="totalCount"
                    ></el-pagination>
                </el-col>
            </el-col>
        </el-row>

        <!-- 图片预览 -->
        <!--<preview></preview>-->

        <!--<el-dialog :title="exchangeDialogTitle" :visible.sync="isShowExchange" size="small">-->
            <!--<exchange-list :gift_id="currentGiftId"></exchange-list>-->
        <!--</el-dialog>-->

        <!--&lt;!&ndash; 添加表单 &ndash;&gt;-->
        <!--<el-dialog title="添加XX" :visible.sync="isShowAdd" size="tiny">-->
            <!--<add-form @close="isShowAdd = false" @add-credit-gift="getList"></add-form>-->
        <!--</el-dialog>-->

        <!--&lt;!&ndash; 编辑表单 &ndash;&gt;-->
        <!--<el-dialog title="编辑XX" :visible.sync="isShowEdit" size="tiny">-->
            <!--<edit-form @close="isShowEdit = false" @edit-credit-gift="getList" :gift="currentGift"></edit-form>-->
        <!--</el-dialog>-->
    </div>
</template>
<script>
    import api from "../../api/index"


    export default {
        data: function () {
            return {
                searchForm: {
                    key: '',
                    keyword: '',
                    status: '',
                    page: 1
                },
                reply : '',
                totalCount: 1000,
                list: [],
                selectionList: []
            }
        },
        methods: {
            async example(){
                let reply = await api.auth.roles.example();
                this.reply = reply;
            },
            exportData(){
                this.$message.success('导出数据成功');
            },
            add(){
                this.$message.success('添加数据成功');
            },
            getList(){
                this.list = [];
                let i = parseInt(Math.random()*1000);
                let j = i + 10;
                for(; i < j; i ++){
                    this.list.push({
                        name: 'test' + i,
                        desc: 'test desc ' + i,
                        type: 'type ' + i,
                        status: parseInt(Math.random() * 1000) % 2
                    });
                }
            },
            // 搜索列表
            search(){
                this.getList();
            },
            // 翻页
            changePage(){
                this.getList();
            },
            // 改变状态
            changeStatus(row){
                row.status = row.status === 1 ? 2 : 1;
            },
            // 列表项选中事件
            selectionChange(list){
                this.selectionList = list;
            },
            // 批量启用
            batchEnable(){
                let _self = this;
                if(_self.selectionList.length <= 0){
                    this.$message.warning('请先选择项目');
                    return false;
                }
                this.$confirm('确定要启用你所选择的项目吗? ').then(() => {
                    _self.selectionList.forEach(item => {
                        item.status = 1;
                    });
                });
            },
            // 批量禁用
            batchDisable(){
                let _self = this;

                if(_self.selectionList.length <= 0){
                    this.$message.warning('请先选择项目');
                    return false;
                }
                this.$confirm('确定要禁用你所选择的项目吗? ').then(() => {
                    _self.selectionList.forEach(item => {
                        item.status = 2;
                    });
                });
            },
            moreMenuClick(options){
                this.$message.success('您点击了 ' + options + ' 选项');
            }
        },
        created: function () {
            this.getList();
        }
    }
</script>
