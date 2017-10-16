<template>
    <el-row>
        <el-col :span="24">
            <el-table :data="list" v-loading="loading" stripe style="width: 100%">
                <el-table-column prop="employee_code" label="员工工号" header-align="center" align="center"></el-table-column>
                <el-table-column prop="employee_name" label="员工姓名" header-align="center" align="center"></el-table-column>
                <el-table-column prop="employee_mobile" label="电话号码" header-align="center" align="center"></el-table-column>
                <el-table-column prop="fee_credit" label="兑换积分" header-align="center" align="center"></el-table-column>
                <el-table-column label="兑换时间" header-align="center" align="center">
                    <template scope="scope">
                        <span>{{ new Date(scope.row.exchange_time * 1000).format('yyyy-MM-dd hh:mm:ss') }}</span>
                    </template>
                </el-table-column>
            </el-table>
            <div class="fr m-t-20">
                <el-pagination
                        layout="prev, pager, next"
                        :total="totalCount"
                        :page-size="pageSize"
                        :current-page.sync="currentPage"
                        @current-change="getList">
                </el-pagination>
            </div>
        </el-col>
    </el-row>
</template>

<script>

    export default {
        props: {
            gift_id: Number,
        },
        data() {
            return {
                list: [],
                totalCount: 0,
                currentPage: 1,
                pageSize: 10,
                loading: false
            }
        },
        methods: {
             getList() {
                 let _self = this
                 let params = {
                     gift_id : this.gift_id,
                     page    : this.currentPage,
                     pageSize: this.pageSize
                 }
                 _self.loading = true
                 api.get('/api/provider/employeeCredit/gift/exchangeRecords',params).then(res => {
                     _self.loading = false;
                     api.handlerRes(res).then(data => {
                         _self.list = data.list.data;
                         _self.totalCount = data.list.total;
                     })
                 });
             }
        },
        created() {
            this.getList()
        },
        watch: {
            gift_id() {
                this.getList()
            }
        }
    }
</script>