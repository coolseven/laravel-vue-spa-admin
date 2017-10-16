<template>
    <el-row type="flex" justify="center" align="middle">
        <el-col class="login-box">
            <el-card header="Yet Another Laravel-SPA-Admin 管理后台 - 登录">
                <el-form :model="form" ref="form" @keyup.native.enter="doLogin('form')" label-position="left" label-width="0px" >
                    <el-form-item prop="username">
                        <el-input type="text" v-model="form.username" auto-complete="off" placeholder="账号"></el-input>
                    </el-form-item>
                    <el-form-item prop="password">
                        <el-input type="password" v-model="form.password" auto-complete="off" placeholder="密码"></el-input>
                    </el-form-item>
                    <el-form-item prop="captcha">
                        <el-input type="text" v-model="form.captcha" auto-complete="off" placeholder="验证码"
                                  class="w-150"></el-input>
                        <img :src="captcha_img_src" @click="refreshCaptcha()" width="150" style="right: 0; cursor: pointer;" class="captcha-img"/>
                    </el-form-item>
                    <el-form-item style="width:100%;">
                        <el-button type="primary" style="width:100%;" v-loading="loading"
                                   @click.native.prevent="doLogin('form')">登录
                        </el-button>
                    </el-form-item>
                </el-form>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
    import api from "../api/index"
    export default {
        data(){
            return {
                captcha_img_type: 'easy',   // other available types can be found at /config/captcha.php
                captcha_img_src:  '',
                form: {
                    username: '',
                    password: '',
                    captcha: ''
                },
                loading: false
            }
        },
        methods: {
            getCaptchaUrl(){
                return location.protocol + '//' +location.host + '/captcha/' + this.captcha_img_type ;
            },
            refreshCaptcha(){
                this.captcha_img_src = this.getCaptchaUrl() + '?v=' + Math.random();
            },
            redirect() {
                try {
                    let user_home_page = this.$store.getters.userHomePage;
                    this.$router.replace(user_home_page);
                } catch(error){
                    this.$router.replace({
                        path: '/503',
                        params: {
                            'message' : '您未被分配任何页面的访问权限,请联系管理员!'
                        }
                    })
                }
            },
            async doLogin(){
                this.loading = true;
                try {
                    await this.$store.dispatch('login',this.form)
                    this.redirect();
                } catch(err){
                    this.loading = false;
                    this.refreshCaptcha();
                }
            }
        },
        created: function () {
            if (this.$store.getters.userHasLoggedIn) {
                this.redirect();
            }else{
                this.refreshCaptcha()
            }
        }
    }

</script>

<style>
    .login-box {
        margin-top: 120px;
        width:400px;
    }
    .captcha-img {
        position: absolute;
        right: 100px;
        top: 0;
    }

</style>