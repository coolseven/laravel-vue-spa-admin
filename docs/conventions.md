# Laravel-SPA-Admin 项目开发约定与团队代码规范

## 更新日志
- 更新时间： 2017-09-17  - 更新人员： 胡中园

## 开发约定
- 项目中所有文本文件的编码统一设置为 utf-8
- docs 目录下的文档,必须为 .md 格式(方便版本管理工具追踪变化), 文件名必须为英文(以免在 unix 环境下出现文件名乱码问题)
- 为方便文档和代码的阅读,请在 IDE 中使用等宽字体,以便对齐
- 为保证每个开发人员电脑上依赖的版本是相同的，请不要删除 package-lock.json 和 composer.lock
- 需要安装新依赖时，优先使用命令行的方式来安装依赖(而不是直接修改配置文件)，即 `composer require xxx` / `composer require-dev xxx` 和 `npm install xxx` / `npm install xxx --save-dev`
- 需要升级某个依赖时，优先使用命令行的方式来升级某个依赖(而不是直接修改配置文件)，并且需要显式指定需要升级的 package ，即 `composer update package-name` 或 `npm update package-name` 
- `composer update` 和 `npm update` 如果不指定需要升级的 package ，将会一次性升级所有可升级的依赖，这**可能会导致未知的问题**，请谨慎使用!!
- 由于 vendor 和 node_modules 等目录不在版本管理中,因此,在安装或升级依赖后，请及时通知其他开发人员
- 由于 IDE 没有智能提示,以及为了多人协作的方便,请尽量不要在 session 中或者 $request 这个全局对象中挂载任何"热点"数据,所有数据都统一通过相关的 Service 去获取
- 如果 $request 全局对象上或者 session 中确实需要挂载数据,请在本文档的 'Session 约定' 或 '$request 对象约定' 小节中留下挂载的数据清单,以方便他人维护
- 使用 TODO, FIXME , HACK ,NOTICE ,WARNING 等关键字,方便他人阅读代码,以及为后期的持续集成系统(如果有)作准备
- 前端编写异步函数时,优先选择返回 Promise 的形式, 而不是选择指定 callback 参数作为回调函数


## Session 约定
- 目前,普通用户登陆成功后,session 中保存且仅保存以下的信息:
  - 用户是否已登录,    即: Session::put('user_has_logged_in' ,true);  可用于登录验证和注销等
  - 当前登录用户的 id, 即: Session::put('user_id' ,1); 可用于调用其它 Service 进行用户信息的获取,用户权限验证等
- 目前,installer 用户登陆成功后,session 中保存且仅保存以下的信息:  
  - Session::put('user_has_logged_in',true);
  - Session::put('current_user_is_installer',true);  

## $request 对象约定
目前,$request 全局对象上并未挂载任何数据  

## 接口规范
### 接口命名约定
- 查找单条记录:   
  - 后端:read         
  - 前端:read
- 分页获取记录集:   
  - 后端:paginate     
  - 前端:paginate
- 获取全部记录集:   
  - 后端:all          
  - 前端:all
- 创建一条新纪录:    
  - 后端:create       
  - 前端:create
- 修改一条记录:   
  - 后端:modify       
  - 前端:modify
- 删除一条记录:   
  - 后端:delete       
  - 前端:remove

## 代码规范
- 代码规范应由集体共同制定,
  - 代码规范制定之前,不同的开发者可以随意使用自己喜欢的代码风格
  - 代码规范制定之后,需统一将现有代码修改为符合代码规范的格式
- 备注: 目前项目中已写的代码中使用到了以下的规范,仅供参考:
  - 变量名使用了 snake_case 的形式, 
  - 方法名使用了 camelCase  的形式
  - 数组类型的变量,命名为该数组中的元素的名称的复数形式, 如: $books = getAuthorBooks($author_id);
  - vue 组件的文件名使用了 组件模块-组件功能-组件类型 的形式, 如: role-create-form.vue , user-role-tags.vue 
  - artisan 自定义 command 使用了 YourCommandName 的形式, 如: `php artisan make:command AppInstall` , 同时,在生成的 Console\Commands\AppInstall.php 中,将 signature 设置为 `app:your-command` 的形式, 如: `app:install`