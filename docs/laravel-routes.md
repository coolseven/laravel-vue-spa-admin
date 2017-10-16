# Laravel-SPA-Admin 后端路由说明

### 更新记录

-   更新时间： 2017-10-12  - 更新人员： 胡中园

### 相关文件:
#### 路由定义 ( uri - controller )
- routes/web.php
- routes/api.php
#### 中间件定义 ( middlewareGroupName - middlewareList )
- app/Http/Kernel.php
#### 给路由分配中间件 ( route - middlewareGroupName )
- app/Providers/RouteServiceProvider

### 查看当前的后端路由列表:  
代码根目录下,打开 cmd 窗口,执行:
```bash
php artisan route:list
```
得到的路由清单形如下面的结构:
```
+--------+----------------------------------------+----------------------------+----------------------------+---------------------------------------------------------+------------+
| Domain | Method                                 | URI                        | Name                       | Action                                                  | Middleware |
+--------+----------------------------------------+----------------------------+----------------------------+---------------------------------------------------------+------------+
|        | POST                                   | api/auth/menus/all         | api.auth.menus.all         | App\Http\Controllers\Auth\MenusController@all           | app.api    |
|        | POST                                   | api/auth/menus/save        | api.auth.menus.save        | App\Http\Controllers\Auth\MenusController@save          | app.api    |
|        | POST                                   | api/auth/role/apis         | api.auth.role.apis         | App\Http\Controllers\Auth\RolesController@apis          | app.api    |
|        | POST                                   | api/auth/role/basic        | api.auth.role.basic        | App\Http\Controllers\Auth\RolesController@basic         | app.api    |
|        | POST                                   | api/auth/role/create       | api.auth.role.create       | App\Http\Controllers\Auth\RolesController@create        | app.api    |
|        | POST                                   | api/auth/role/delete       | api.auth.role.delete       | App\Http\Controllers\Auth\RolesController@delete        | app.api    |
|        | POST                                   | api/auth/role/detachUser   | api.auth.role.detachUser   | App\Http\Controllers\Auth\RolesController@detachUser    | app.api    |
|        | POST                                   | api/auth/role/menus        | api.auth.role.menus        | App\Http\Controllers\Auth\RolesController@menus         | app.api    |
|        | POST                                   | api/auth/role/modifyApis   | api.auth.role.modifyApis   | App\Http\Controllers\Auth\RolesController@modifyApis    | app.api    |
|        | POST                                   | api/auth/role/modifyMenus  | api.auth.role.modifyMenus  | App\Http\Controllers\Auth\RolesController@modifyMenus   | app.api    |
|        | POST                                   | api/auth/role/modifyRoutes | api.auth.role.modifyRoutes | App\Http\Controllers\Auth\RolesController@modifyRoutes  | app.api    |
|        | POST                                   | api/auth/role/users        | api.auth.role.users        | App\Http\Controllers\Auth\RolesController@users         | app.api    |
|        | POST                                   | api/auth/roles/all         | api.auth.roles.all         | App\Http\Controllers\Auth\RolesController@all           | app.api    |
|        | POST                                   | api/auth/roles/paginate    | api.auth.roles.paginate    | App\Http\Controllers\Auth\RolesController@paginate      | app.api    |
|        | POST                                   | api/auth/user/create       | api.auth.user.create       | App\Http\Controllers\Auth\UsersController@create        | app.api    |
|        | POST                                   | api/auth/user/delete       | api.auth.user.delete       | App\Http\Controllers\Auth\UsersController@delete        | app.api    |
|        | POST                                   | api/auth/user/detachRole   | api.auth.user.detachRole   | App\Http\Controllers\Auth\UsersController@detachRole    | app.api    |
|        | POST                                   | api/auth/user/modify       | api.auth.user.modify       | App\Http\Controllers\Auth\UsersController@modify        | app.api    |
|        | POST                                   | api/auth/users/paginate    | api.auth.users.paginate    | App\Http\Controllers\Auth\UsersController@paginate      | app.api    |
|        | POST                                   | api/session/sync           | api.session.sync           | App\Http\Controllers\SyncController@sync                | app.api    |
|        | POST                                   | api/user/login             | api.user.login             | App\Http\Controllers\LoginController@login              | app.api    |
|        | POST                                   | api/user/logout            | api.user.logout            | App\Http\Controllers\LoginController@logout             | app.api    |
|        | GET|HEAD                               | captcha/{config?}          | app.captcha                | \Mews\Captcha\CaptchaController@getCaptcha              | app.web    |
|        | GET|HEAD                               | logs                       | app.logs                   | \Rap2hpoutre\LaravelLogViewer\LogViewerController@index |            |
|        | GET|HEAD|POST|PUT|PATCH|DELETE|OPTIONS | {else}                     | app                        | App\Http\Controllers\AppController@index                | app.web    |
+--------+----------------------------------------+----------------------------+----------------------------+---------------------------------------------------------+------------+
```

### 路由清单说明
- 该路由清单中的每一行代表一个后端路由,
- 当有请求到达时,laravel 需要从上面的清单中寻找当前请求相关联的路由.  
- 寻找的顺序是从上往下挨个遍历,找到关联的路由之后,即可终止剩余路由查找.   

寻找的依据是
- 当前的请求的 Method 与清单中的 Method 相同
- 当前的请求的 URI 与清单中的 URI 相同
- 上述的两个依据需要同时满足

这些路由从类型上可以分为两类:
- api 路由
约定:
  - URI 统一以 `api/` 开头
  - 统一以 POST 方式作为 Method
- web 路由
约定:
  - URI 不以 `api/` 开头
  - Name 为 `app` 的路由必须是路由清单中的最后一条路由
  
### `app` 路由说明
在上述的路由清单中,有一条比较难以理解的路由,即最后一条 Name 为 `app` 的路由
- 它对 Method 和 URI 没有任何限制,可以匹配任何请求,因此它可以作为系统的保底路由,作用是保证其他的路由全部不匹配时,进入该保底路由进行处理
- 同理,作为一个"万能"的路由,它禁止放在任何路由的上方,否则位于它下方的路由永远没有机会执行
哪些路由会进入该保底路由?
- 以 `api/` 开头,但 Method 为 GET 类型, 这种一般是前端 js 把 POST 误写成了 GET
- 以 `api/` 开头,Method 为 POST 类型, 但请求的 URI 在后端的 api 路由中未找到, 这种一般是前端添加了新的 api,但是后端忘记在 routes/api.php 文件中补充对应的路由
- 不以 `api/` 开头,但请求头中设置的是 `Accept: application/json`, 这种一般是未知的第三方请求
- 不以 `api/` 开头,且请求头中设置是 `Accept: text/html`, 这种一般是用户手动刷新了当前页面产生的正常请求. (当然,也有可能是未知的第三方请求)

- 对于前三种,后端均返回一个 json 响应,响应内容中包含 ApiNotFound 的 message 提示
- 对于第四种,后端返回一个 html 页面响应,响应内容为 resources/views/app.blade.php





