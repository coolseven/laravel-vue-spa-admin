import NotFound from '../pages/404.vue'
import Error from '../pages/503.vue'
import Dashboard from '../pages/dashboard.vue'
import Login from '../pages/login.vue'

import Welcome from '../components/index/welcome.vue'
import Refresh from '../components/layout/refresh.vue'


import SystemMenus from '../components/system/menus/menus-list.vue'
import AuthRoles from '../components/auth/roles/roles-panel.vue'
import AuthUsers from '../components/auth/users/users-list.vue'
import InstallComplete from '../components/system/complete.vue'

const routes = [

    {
        path: '/', component: Dashboard,children:[
            {   path: '',                   redirect: '/welcome'},
            {   path: '/welcome',           component: Welcome,         name: '欢迎页',           meta: { guarded: true,   canBeSetAsMenu: true,  description: '登录后的欢迎页' } },
            {   path: '/refresh',           component: Refresh,         name: '刷新页',           meta: { guarded: false,  canBeSetAsMenu: false, description: '函数型组件，禁止作为左侧菜单'} },

            {   path: '/system/menus',      component: SystemMenus,     name:'系统菜单',          meta: { guarded: true ,  canBeSetAsMenu: true ,  description: '系统菜单的设置,系统菜单是其他角色的菜单的基础' } },
            {   path: '/auth/roles',        component: AuthRoles,       name:'角色管理',          meta: { guarded: true ,  canBeSetAsMenu: true } },
            {   path: '/auth/users',        component: AuthUsers,       name:'用户管理',          meta: { guarded: true ,  canBeSetAsMenu: true } },
            {   path: '/install/complete',  component: InstallComplete, name:'完成',              meta: { guarded: true ,  canBeSetAsMenu: true } },

        ]
    },
    {   path: '/login',             component: Login,           name: '登录页',          meta: { guarded: false,  canBeSetAsMenu: false, description: '未登录时强制展示'       } },
    {   path: '/503',               component: Error,           name: '错误页',          meta: { guarded: false,  canBeSetAsMenu: false, description: '应用不可用时展示'       } },
    {   path: '/404',               component: NotFound,        name: '404页',           meta: { guarded: false,  canBeSetAsMenu: false, description: '无匹配的路由时自动展示'}},
    {
        path: '*', redirect: '/404'
    }

];


export default routes
