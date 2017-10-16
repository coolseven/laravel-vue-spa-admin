import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// 初始化VueRouter
import routes from './routes'
const router = new VueRouter({
    mode: 'history',
    routes
});

import store from '../store'


/**
 * router 的功能如下：
 * 1. 在切换到下个页面前，检查用户的登陆状态
 * 2. 在切换到下个页面前，检查用户的路由访问权限 TODO
 * 3. 刷新网页后，将用户信息以及其他信息从服务端(session) 恢复到浏览器端(vuex) 中
 *
 */
router.beforeEach((to, from, next) => {

    if (to.path === '/404') {
        next();
        return;
    }

    let userHasLoggedIn = store.getters.userHasLoggedIn;
    if(!userHasLoggedIn){
        if (to.path === '/login') {
            next()
        }else{
            store.dispatch('sync').then((synced)=>{
                let user_has_logged_in = store.getters.userHasLoggedIn;
                if (user_has_logged_in) {
                    next()
                }else{
                    next('/login')
                }
            }).catch((error)=>{
                next('/login')
            });
        }
    }else{
        next()
    }
})

router.afterEach(transition => {

})



export default router;