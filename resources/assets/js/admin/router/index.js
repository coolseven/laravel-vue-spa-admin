import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// 初始化VueRouter
import {routes} from './routes'
const router = new VueRouter({
    mode: 'history',
    routes
});

import store from '../store'
import { Message } from 'element-ui'

/**
 * router 的功能如下：
 * 1. 在切换到下个页面前，检查用户的登陆状态
 * 2. 在切换到下个页面前，检查用户的路由访问权限
 * 3. 刷新网页后，将用户信息以及其他信息从服务端恢复到浏览器端(vuex)
 *
 */
router.beforeEach((to, from, next) => {

    if (to.path === '/404') {
        next();return;
    }

    let user_has_logged_in = store.getters.userHasLoggedIn;

    if(!user_has_logged_in){
        if (to.path === '/login') {
            next()
            // 备注: 此处需要加 return ,否则 next() 后面的代码依然会执行
            return;
        }

        store.dispatch('sync')      // if user pressed F5, we need to restore user's state into vuex
        .then(()=>{
            let user_has_logged_in = store.getters.userHasLoggedIn;
            if (user_has_logged_in) {
                if (to.meta && to.meta.guarded) {
                    // FIXME 这段逻辑和下面其中一块的逻辑是重复的,需要优化
                    let user_can_visit_route = store.state.user.routes.some(route => route.path === to.path)
                    if (!user_can_visit_route) {
                        Message({
                            message : '抱歉,您没有权限访问该页面. ('+ to.path + ')' , type : 'error', duration: 5 * 1000
                        });
                        let userHomePage = store.getters.userHomePage
                        next(userHomePage)
                    }
                }
                next()
            }else{
                next('/login')
            }
        })
        .catch(()=>{
            next('/login')
        });

    }else{
        if (to.meta && to.meta.guarded) {
            let user_can_visit_route = store.state.user.routes.some(route => route.path === to.path)
            if (!user_can_visit_route) {
                Message({
                    message : '抱歉,您没有权限访问该页面. ('+ to.path + ')' , type : 'error', duration: 5 * 1000
                });
                next(false)
            }else{
                next()
            }
        }else{
            next()
        }
    }
})

router.afterEach(transition => {

})



export default router;