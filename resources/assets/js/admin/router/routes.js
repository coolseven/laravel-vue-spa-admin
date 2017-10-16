import NotFound from '../pages/404.vue'
import Error from '../pages/503.vue'
import Dashboard from '../pages/dashboard.vue'
import Login from '../pages/login.vue'

import Welcome from '../components/index/welcome.vue'
import Refresh from '../components/layout/refresh.vue'

import PlainExample from '../components/example/plain.vue'
import TableExample from '../components/example/table.vue'
import FormExample from '../components/example/form.vue'
import DetailExample from '../components/example/detail.vue'
import ChartExample from '../components/example/chart.vue'
import ApiExample from '../components/example/api.vue'

import AuthRoles from '../components/auth/roles/roles-panel.vue'
import AuthUsers from '../components/auth/users/users-list.vue'
import SystemMenus from '../components/system/menus/menus-list.vue'



const routes = [

    {
        path: '/', component: Dashboard,children:[
            {   path: '',                   redirect: '/welcome'},
            {   path: '/welcome',           component: Welcome,         name: '欢迎页',           meta: { guarded: true,   canBeSetAsMenu: true,  description: '登录后的欢迎页' } },
            {   path: '/refresh',           component: Refresh,         name: '刷新页',           meta: { guarded: false,  canBeSetAsMenu: false, description: '函数型组件，禁止作为左侧菜单'} },

            {   path: '/example/plain',     component: PlainExample,    name:'文字示例',          meta: { guarded: false , canBeSetAsMenu: true  } },
            {   path: '/example/table',     component: TableExample,    name:'表格示例',          meta: { guarded: true ,  canBeSetAsMenu: true  } },
            {   path: '/example/form',      component: FormExample,     name:'表单示例',          meta: { guarded: true ,  canBeSetAsMenu: true  } },
            {   path: '/example/detail',    component: DetailExample,   name:'详情示例',          meta: { guarded: true ,  canBeSetAsMenu: true  } },
            {   path: '/example/chart',     component: ChartExample,    name:'图表示例',          meta: { guarded: true ,  canBeSetAsMenu: true  } },
            {   path: '/example/api',       component: ApiExample,      name:'接口示例',          meta: { guarded: true ,  canBeSetAsMenu: true  } },

            {   path: '/auth/roles',        component: AuthRoles,       name:'角色管理',          meta: { guarded: true ,  canBeSetAsMenu: true } },
            {   path: '/auth/users',        component: AuthUsers,       name:'用户管理',          meta: { guarded: true ,  canBeSetAsMenu: true } },
            {   path: '/system/menus',      component: SystemMenus,     name:'系统菜单',          meta: { guarded: true ,  canBeSetAsMenu: true ,  description: '系统菜单设置,角色菜单是系统菜单的子集' } },

        ]
    },
    {   path: '/login',             component: Login,           name: '登录页',          meta: { guarded: false,  canBeSetAsMenu: false, description: '未登录时强制展示'       } },
    {   path: '/503',               component: Error,           name: '错误页',          meta: { guarded: false,  canBeSetAsMenu: false, description: '应用不可用时展示'       } },
    {   path: '/404',               component: NotFound,        name: '404页',           meta: { guarded: false,  canBeSetAsMenu: false, description: '无匹配的路由时自动展示'}},
    {
        path: '*', redirect: '/404'
    }

];

import _ from 'lodash'

// 需要权限验证的路由(一维数组)
let guarded_routes = [];
_.each(routes, (route) => {
    if ( !(_.has(route,'children')) && route.name !== undefined && _.get(route,'meta.guarded',false) ) {
        guarded_routes.push({'name':route.name, 'path':route.path})
    }
    _.each(route.children, (child) => {
        if (child.name !== undefined  && _.get(child,'meta.guarded',false) ) {
            guarded_routes.push({'name':child.name, 'path':child.path})
        }
    })
})

// 可以作为左侧菜单的路由(一维数组)
let menu_able_routes = [];
_.each(routes, (route) => {
    if ( !(_.has(route,'children')) && route.name !== undefined && _.get(route,'meta.canBeSetAsMenu',false) ) {
        menu_able_routes.push({'name':route.name, 'path':route.path})
    }
    _.each(route.children, (child) => {
        if (child.name !== undefined  && _.get(child,'meta.canBeSetAsMenu',false) ) {
            menu_able_routes.push({'name':child.name, 'path':child.path})
        }
    })
})

export {routes,guarded_routes,menu_able_routes}
