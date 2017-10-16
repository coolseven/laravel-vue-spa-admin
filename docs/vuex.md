# Laravel-SPA-Admin issue 前端状态管理

### 更新记录

-   更新时间： 2017-09-17  - 更新人员： 胡中园

### 当前 vuex 状态结构

```js
state: {
        app:{
            name:'Yet Another Laravel-SPA-Admin',
            title:'Yet Another Laravel-SPA-Admin'
        },
        user:{
            username:'',
            roles:[],
            menus:[],
            routes:[],
            apis:[]
        },
        session: {
            visited_tabs : []
        },
        system : {
            roles: [],
            menus: [],
            apis : [],
        }
    }
```

### app

保存应用的基础信息

-   name , 应用名称,展示在页面左上角
-   title, 网页标题

## user 
保存当前登录用户的基础信息和权限信息

- username 用户名，会展示在页面的右上角
- roles  用户所属的角色数组，目前无用处
- menus  用户的左侧菜单树(二维数组)，用于 dashboard 页面 left-menu 组件的展示
- routes 用户可访问的路由(一维数组)，用于拦截无权限的路由访问 
- apis   用户可使用的 api (一维数组) ,用于拦截无权限的 api 接口请求

## session 
session 中存放本次会话的一些临时数据. 

功能和 localStorage 相似，区别是 vuex 中的内容实际存储在内存中. 
相对于 localStorage 更适合存储敏感信息
用户退出登录后，记得清除掉 session 中的所有数据

## system
保存系统的权限配置

-   roles ,系统中的角色信息
-   menus, 可分配给角色的左侧菜单的候选项集合
-   apis , 系统的后端所有 api 集合



