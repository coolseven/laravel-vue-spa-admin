<template>

    <div style="margin: 5px 0 0 18px">
        <el-steps :space="100" direction="vertical" :active="current_step" finish-status="success">
            <el-step title="欢迎页"></el-step>
            <el-step title="系统菜单设置"></el-step>
            <el-step title="添加一个角色"></el-step>
            <el-step title="添加一个用户"></el-step>
            <el-step title="完成"></el-step>
        </el-steps>
    </div>
</template>

<script>
    import bus from '../../bus'

    export default {
        data() {
            return {
                step_routes:{
                    1: '/welcome',
                    2: '/system/menus',
                    3: '/auth/roles',
                    4: '/auth/users',
                    5: '/install/complete',
                },
                route_steps:{
                    '/welcome' : 1,
                    '/system/menus' : 2,
                    '/auth/roles' : 3,
                    '/auth/users' : 4,
                    '/install/complete' : 5,
                },
                current_step: 1
            }
        },
        methods: {
            stepForward(){
                let target_step = this.current_step + 1
                let target_path = this.step_routes[target_step]
                if (target_path) {
                    this.current_step ++
                }
                this.$router.push(target_path)
            },
            stepBackward(){
                let target_step = this.current_step - 1
                let target_path = this.step_routes[target_step]
                if (target_path) {
                    this.current_step --
                }
                this.$router.push(target_path)
            },
            init(){
                this.current_step =  this.route_steps[this.$route.path];
            }
        },
        created(){
            bus.$on('next-step',this.stepForward)
            bus.$on('previous-step',this.stepBackward)
            this.init()
        },
        watch:{
            $route(){
                this.init()
            }
        }
    }
</script>