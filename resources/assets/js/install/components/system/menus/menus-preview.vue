<template>
    <div>
        <el-row>
            <p class="text-regular" v-if="menus && menus.length === 0">您可以通过左侧的编辑表单来设置系统菜单</p>
        </el-row>
        <el-row>
            <el-menu theme="dark" :collapse="false" :unique-opened="false" :router="false">
                <template v-for="menu in menus">
                    <el-menu-item v-if="menu.type === 'route'" :index="menu.path">
                        {{menu.name}}
                    </el-menu-item>
                    <el-submenu v-if="menu.type === 'folder'" :index="menu.path">
                        <template slot="title">
                            {{menu.name}}
                        </template>
                        <el-menu-item v-for="child in menu.children" :key="child.path" :index="child.path">
                            {{child.name}}
                        </el-menu-item>
                    </el-submenu>
                </template>
            </el-menu>
        </el-row>

        <div class="dialog-footer fr" style="margin-top: 20px;">
            <el-button v-show="isSubmitButtonVisible()" type="default" @click="reset">清空</el-button>
            <el-button v-show="isRestoreButtonVisible()" type="default" @click="restore">还原</el-button>
            <el-button v-show="isSubmitButtonVisible()" type="primary" @click="submit">提交</el-button>
        </div>

    </div>
</template>
<script>
    import api from '../../../api/index';
    import bus from '../../../bus'
    import _ from '../../../utils/lodash'

    export default {
        props     :{
            menus_to_preview: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                menus: [],
                un_committed_changes: -1,
            }
        },
        methods   : {
            async submit(){
                let found = _.findDeep(this.menus , { path : '/system/menus' });
                if (!found) {
                    try{
                        await this.$confirm('未检测到 "系统菜单设置" 相关的菜单，这将任何用户都无法再更新系统菜单，您确定要这么做吗？','警告',{
                            type: 'warning'
                        })
                    }catch(cancelled){
                        this.$message.info('已取消提交');
                        return Promise.reject('已取消提交');
                    }
                }
                await api.auth.menus.save({ menus: this.menus});
                this.$message.success('已保存')
                this.$store.dispatch('sync');
                this.un_committed_changes = 0;
            },
            reset(){
                this.$emit('reset')
                this.un_committed_changes = 0
            },
            restore(){
                this.$emit('restore');
            },
            isSubmitButtonVisible(){
                return this.menus && this.menus.length > 0;
            },
            isRestoreButtonVisible(){
                return this.un_committed_changes > 0 ;
            }
        },
        created   : function () {
            this.menus = _.cloneDeep(this.menus_to_preview);
        },
        watch     :{
            menus_to_preview: {
                handler: function(new_menus_to_preview){
                    this.un_committed_changes++ ;
                    this.menus = _.cloneDeep(new_menus_to_preview);
                },
                deep: true,
            }
        }
    }
</script>
