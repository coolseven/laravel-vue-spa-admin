[TOC]

# Laravel-SPA-Admin 相关分享

### 后台演示
- 基础介绍
- 功能介绍

### 相关技术与概念
- CI / Laravel / TP 框架对比
- composer / IOC container 
- 单页面应用 / 多页面应用 / 前后端分离
- 后端工具
  - composer
- 前端工具
  - NodeJs
  - Webpack
- laravel 
  - 路由
  - 中间件
  - Api 响应
- Vue
  - vue
  - vue component
  - vuex
  - vue-router
  - element-ui
- 库与工具
  - lodash / underscore
  - vue-devtools
- 前端异步管理
  - ES6 / ES2015
  - Callback
  - Promise
  - Async / Await
  
### 代码目录结构
- 后端
- 前端(开发)
- 前端(线上)

### 一个请求的来龙去脉
#### 编写一个新 api
- 前端定义 api 地址
- 后端添加 api 路由
- 后端实现 Controller/Action
- 管理员给相关角色添加该 api 的访问权限
- 调试该 api 接口是否正确
#### api 请求的途经环节
- 前端组件触发 api 请求
- 前端 http 模块审核当前用户是否具备该 api 的访问权限
- 后端根据 api 的 uri 在后端路由表中进行匹配
- 后端找出匹配的路由配置中指定的中间件清单和控制器方法
- 后端遍历执行中间件,
- 这些中间件中包含一个权限验证的中间件,该中间件从数据库取出当前用户的权限列表,与当前请求的接口进行比对,比对通过才进行下一步操作,否则抛出异常
- 后端执行路由配置中指定的控制器方法
- 后端将控制器方法的结果(或者是之前的步骤中抛出的异常)以 json 的形式响应给前端
- 前端 http 模块审核 json 响应中是否包含异常信息,如果包含,则弹窗提示,否则将 json 响应返回给触发该请求的组件
- 前端组件使用 json 响应进行相关的业务操作和界面更新

### 以登录组件为例, 介绍 vue 组件的结构与生命周期
login.vue

### 演示如何编写一个展示权限敏感日志的组件
auth-log-table.vue

### 问答与讨论