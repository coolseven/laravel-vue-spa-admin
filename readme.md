## Yet Another Laravel SPA Admin

### Laravel SPA Admin with RBAC Embeded
在寻找由 vue 编写的开源管理后台的过程中,笔者发现针对由 vue 编写的单页面后台的权限管理问题的讨论不是特别多  

目前网上的一些实现,其基本的思路有两种:

- 一是将角色与权限 hard code 在 vue-router 的配置文件中,
- 二是在登录后,由服务端返回权限信息,然后调用 vue-router 异步加载当前用户的路由配置

第一种方式不太灵活,无法应对需要动态更改角色权限的需求

第二种方式,在修改了某个角色的权限之后,通常需要刷新整个页面,或者重新加载路由模块,复杂度较高

本项目尝试了另一种方式:

用户登录后,将当前用户的路由权限和接口权限清单保存在 vuex 中,

- 对于路由权限,在 vue-router 的 beforeEach 等钩子中对当前用户的目标路由进行拦截.
- 而对于接口权限,则通过 axios 的过滤器,先进行前端的拦截,前端通过后才会请求到后端(后端会再次做接口权限检查)

本项目封装了基于 RBAC 模式的用户-角色-权限管理组件,从而可以可视化地管理系统中的角色,用户,菜单,接口权限,路由权限等

### Credit
- visited-tabs 等组件,参(cao)考(xi) 了 https://github.com/PanJiaChen/vue-element-admin 的实现
- 页面加载动画, 左侧菜单树折叠, 以及 `/resource/assets/js/admin/components/example` 目录下的示例组件,均由 https://github.com/evan-li 提供

### 预览

### 角色管理

![role-auth-management](https://github.com/coolseven/laravel-vue-spa-admin/blob/master/docs/images/role-auth-management.png)

### 用户管理

![role-users-management](https://github.com/coolseven/laravel-vue-spa-admin/blob/master/docs/images/role-users-management.png)

### 系统菜单管理

![system-menus-management](https://github.com/coolseven/laravel-vue-spa-admin/blob/master/docs/images/system-menus-management.png)

### 安装

安装方式以及其他文档请移步: [文档](https://github.com/coolseven/laravel-vue-spa-admin/blob/master/docs/index.md)