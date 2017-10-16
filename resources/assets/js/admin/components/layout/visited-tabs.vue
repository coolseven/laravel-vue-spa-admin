<template>
    <div class='visited-tabs-container'>

        <router-link class="visited-tab" v-for="tag in visitedTabs" :to="tag.path" :key="tag.path">
            <el-tag :closable="true" :type="isActive(tag.path)?'success':''" @close.prevent='removeTab(tag)'>
            {{tag.name}}
            </el-tag>
        </router-link>

    </div>
</template>

<script>
    export default {
        computed: {
            visitedTabs() {
                return this.$store.state.session.visited_tabs.slice(-6)
            }
        },
        methods : {
            removeTab(tab) {
                this.$store.dispatch('remove_tab_from_visited', tab)
            },
            generateRoute() {
                if (this.$route.matched[this.$route.matched.length - 1].name) {
                    return this.$route.matched[this.$route.matched.length - 1]
                }
                this.$route.matched[0].path = '/'
                return this.$route.matched[0]
            },
            addCurrentTab() {
                this.$store.dispatch('add_tab_to_visited', this.generateRoute())
            },
            isActive(path) {
                return path === this.$route.path
            }
        },
        watch   : {
            $route() {
                this.addCurrentTab()
            }
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    .visited-tabs-container {
        display: inline-block;
        vertical-align: top;
        margin-left: 10px;
        .visited-tab {
            margin-left: 10px;
        }
    }
</style>
