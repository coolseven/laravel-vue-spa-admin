import Vue from 'vue'
/*
 * 自定义bus
 *
 *   redirect：       自定义跳转（传递的参数同router，post为post方式传参）
 *                    示例：bus.post = {username: 'username'}; router.push('/')
 *
 **/
const bus = new Vue({

});

export default bus;