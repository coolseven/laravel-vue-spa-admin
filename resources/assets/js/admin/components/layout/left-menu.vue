<template>

    <div>
        <el-menu theme="dark" :default-active="$route.path" @select="menuSelected" :unique-opened="true">
            <template v-for="menu in menus">
                <el-menu-item v-if="!menu.children || menu.children.length <= 0" :index="menu.path">
                    <i v-if="menu.icon" :class="menu.icon"></i>
                    {{menu.name}}
                </el-menu-item>
                <el-submenu v-if="menu.children && menu.children.length > 0" :index="menu.name">
                    <template slot="title">
                        <i v-if="menu.icon" :class="menu.icon"></i>{{menu.name}}
                    </template>
                    <el-menu-item v-for="child in menu.children" :key="child.path" :index="child.path">
                        <i v-if="child.icon" :class="child.icon"></i>
                        {{child.name}}
                    </el-menu-item>
                </el-submenu>
            </template>
        </el-menu>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import bus from '../../bus'
    export default {
        data() {
            return {

            }
        },
        computed: {
            ...mapState({
                menus: state => state.user.menus
            })
        },
        methods: {
            menuSelected(path){
                if (path !== this.$route.path) {
                    this.$router.push(path)
                } else {
                    bus.$emit('refresh-route',path )
                }
            }
        }
    }
</script>