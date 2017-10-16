# Laravel-SPA-Admin issue 集合

## 更新日志
- 更新时间： 2017-09-17  - 更新人员： 胡中园

## 待解决的问题
- [ ] 缺少单元测试和接口文档
- [x] 写一个 `php artisan app:install` 命令以及配套的中间件, 用来进行应用的初始化操作或者后期的修复操作
- [x] 如果一个用户没有分配任何用户组,那么需要在界面上展示一个"请联系管理员分配用户组!!!"
- [x] 切换 路由 时，检查用户是否具有目标路由的访问权限
- [x] 发起 api 请求时，检查当前请求的api 是否匹配用户的 apis 列表
- [ ] 发起 非 post 类型的 api 请求时，未自动携带 csrf-token ， 后端也未验证 csrf-token 
- [x] 同时打开多个标签页时，可能会出现数据干扰的问题 (说明: 不要随意使用 localStorage )
- [x] laravel 的标准中,Models 下的 model 类名不带 s 
- [x] setup 界面的左侧应该将 left-menu 组件修改为 steps 组件 
- [ ] 数据存储迁移到 mongodb, 如果使用 mysql ,那么部分字段应该改成 json 格式,如角色的菜单列表,角色的接口列表等
- [ ] helpers.php 文件应该通过 AppServiceProvider 的 boot 方法来加载,而不是直接放在 bootstrap/autoload.php 里面
- [ ] 从 laravel 5.4 升级到 laravel 5.5 
- [x] 去掉 bootstrap.js 

### 待完善的问题

- [ ] 登录功能应该增加失败次数限制
- [ ] 角色管理,用户管理,系统菜单管理等功能,需要对敏感操作进行日志记录和展示
- [ ] 后端更新了资源或服务时，无法及时通知应用来自动刷新浏览器,从而加载新的资源
- [ ] 异常处理逻辑原来是由 ExceptionHandler 统一处理, 在升级到 laravel 5.5 之后,每个异常可以独立处理
- [ ] 编写前端的错误处理,并上报到服务器,因为组件中编写的 console.log() 在 prod 模式下打包时会被删除
- [ ] 角色管理界面的 role-api-table 组件,对其滚动条进行美化
- [ ] 开发模式下,添加 clockwork 的 ServiceProvider ,以方便查看执行的 sql 详情
- [ ] 在 installation.md 中补充需要手动添加的 ignored 文件或目录列表
- [ ] 编写上线步骤的文档
- [ ] 页面布局优化为 flex/grid 
- [ ] 优化部分组件中的多余的 deepClone 操作
- [ ] 检查组件中是否存在在 create 阶段就开始修改模板元素的错误用法

## 待讨论的问题
- [ ] laravel 方法与方法之间是传递普通的数组还是传递 collection 
- [x] cache 的 store , key, 默认过期时间的配置,管理和封装
- [ ] 团队代码规范
- [x] 是否使用 laravel 的 migration 等功能来做数据库版本管理 (否 , 因为后期可能要 mysql + mongodb 混用)
- [ ] 接口身份认证方案的选择 （session or token）,目前是 session
- [ ] 目前左侧菜单树支持两级菜单,是否修改成仅支持一级
- [ ] 前台和后台都可以校验用户的 api 权限， 但是后台只能限制站内的 api 请求，如果需要针对部分用户做到拦截发向站外的请求怎么办？
- [ ] 是否需要对 api 请求做更精细的控制,比如根据请求中的部分参数来动态限制权限等