<template>
    <el-row class="panel m-w-1280">
        <el-row class="panel-top">
            <div class="w-180 panel-logo">
                <template v-if="logo_type == 'pic'">
                    <!--<img src="../../../images/logo_user.png" class="logo">-->
                </template>
                <template v-else>
                    <span class="p-l-20 ">{{title}}</span>
                </template>
            </div>
            <div class="panel-top-menu">
                <el-col :span="1">
                    <div class="menu-switch" @click="showLeftMenu = !showLeftMenu"><i class="fa fa-bars"></i></div>
                </el-col>

                <el-col :span="20">
                    <p>&nbsp;</p>
                </el-col>

                <el-col :span="1">
                    <span class="fa fa-arrows-alt toggle-full-screen" @click="toggleFullScreen"></span>
                </el-col>

                <el-col :span="2">
                    <el-menu theme="dark" mode="horizontal" @select="topMenuSelected">
                        <el-submenu index="options" style="float: right; right: 40px;">
                            <template slot="title">{{username}} <i class="fa fa-user" aria-hidden="true"></i></template>
                            <el-menu-item index="sync">数据同步</el-menu-item>
                        </el-submenu>
                    </el-menu>
                </el-col>
            </div>

        </el-row>

        <el-col :span="24" class="panel-center">
            <aside class="w-180" v-show="showLeftMenu">
                <leftMenu></leftMenu>
            </aside>
            <section class="panel-c-c" :class="{'hide-leftMenu': !showLeftMenu}">
                <div class="grid-content bg-purple-light">
                    <el-col :span="24">
                        <transition name="fade" mode="out-in" appear>
                            <!--<keep-alive>-->
                                <router-view v-loading="showLoading"></router-view>
                            <!--</keep-alive>-->
                        </transition>
                    </el-col>
                </div>
            </section>
        </el-col>
    </el-row>
</template>

<script>
    import LeftMenu from '../components/layout/left-menu.vue'
    import fullsScreen from 'screenfull'
    import {mapState} from "vuex"

    export default {
        data() {
            return {
                showLeftMenu: true,
                showLoading: false,
                hasChildMenu: false,
                img: '',
                title: '',
                logo_type: null
            }
        },
        computed: {
            ...mapState({
                username: state => state.user.username
            })
        },
        methods: {
            async topMenuSelected(action, keyPath){
                switch (action) {
                    case 'sync':
                        await this.$store.dispatch('sync')
                        this.$message.success('数据同步成功')
                        break
                }
            },
            toggleFullScreen(){
                (fullsScreen.enabled && fullsScreen.toggle()) || this.$message.warn('您的浏览器不支持全屏')
            }
        },
        created() {
            // TODO these settings should be sync with vuex
            this.logo_type = 'text';
            this.title = 'Yet Another Laravel-SPA-Admin';
            document.title = 'Yet Another Laravel-SPA-Admin-系统初始化';
        },
        components: {
            LeftMenu,
        }
    }
</script>

<style>
    span.toggle-full-screen{
        margin-left: 30%;
    }

    .el-submenu [class^=fa] {
        vertical-align: baseline;
        margin-right: 10px;
    }

    .el-menu-item [class^=fa] {
        vertical-align: baseline;
        margin-right: 10px;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .1s
    }
    .fade-enter,
    .fade-leave-active {
        opacity: 0
    }

    .panel {
        background: #324057;
        position: absolute;
        top: 0px;
        bottom: 0px;
        width: 100%;
    }
    .panel-top {
        height: 60px;
        line-height: 60px;
        color: #c0ccda;
        display: flex;
    }
    .panel-top-menu {
        flex: 1;
    }

    .panel-center {
        /*background: #324057;*/
        position: absolute;
        top: 60px;
        bottom: 0px;
        overflow: hidden;
    }

    .panel-c-c {
        background: #f1f2f7;
        position: absolute;
        right: 0px;
        top: 0px;
        bottom: 0px;
        left: 180px;
        overflow-x: hidden;
        padding: 5px 20px 0px 20px;

        transition: left .5s;
        -webkit-transition: left .5s;
        -moz-transition: left .5s;
        -o-transition: left .5s;
    }

    .hide-leftMenu {
        left: 0;
        transition: left 0.5s;
        -webkit-transition: left .5s;
        -moz-transition: left .5s;
        -o-transition: left .5s;
    }

    .panel-logo {
        /*background-color: #324057;*/
        display: inline-block;
    }

    .logo {
        width: 150px;
        float: left;
        margin: 10px 10px 10px 18px;
    }

    .logout {
        /*background: url(../../../images/logout_36.png);*/
        background-size: contain;
        width: 20px;
        height: 20px;
        float: left;
    }
    .tip-logout {
        float: right;
        margin-right: 20px;
        padding-top: 5px;
        cursor: pointer;
    }

    .admin {
        color: #c0ccda;
        text-align: center;
    }

    .menu-switch {
        cursor: pointer;
    }

    .breadcrumbs{
        margin-top: 23px;
    }
    .el-breadcrumb__item{
        color: #97a8be !important;
    }
    .el-breadcrumb__item__inner a{
        color: #97a8be !important;
    }
    .el-breadcrumb__item__inner, .el-breadcrumb__item__inner a{
        color: #97a8be !important;
    }
</style>