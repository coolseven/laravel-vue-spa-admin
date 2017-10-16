## Laravel-SPA-Admin 项目结构说明

## 更新日志
- 更新时间： 2017-09-17  - 更新人员： 胡中园

### 目录说明

- 根目录

    - `app` 目录 

        > app 目录，包含应用程序的核心代码。

    - `bootstrap` 目录

        > `bootstrap` 目录包含了几个框架启动和自动加载设置的文件。内部的 `cache` 文件夹用于包含框架为提升性能所生成的文件，如路由和服务缓存文件。

    - `config` 目录

        > `config` 目录，包含应用的配置文件。

    - `database` 目录

        > `database` 目录包含了数据迁移及填充文件

    - `public` 目录

        > `public` 目录包含了 Laravel 的 HTTP 入口文件 `index.php` 和 webpack 帮忙打包出来的前端文件（图片、JavaScript、CSS等）

    - `resources` 目录

        > `resources` 目录包含了视图、原始的资源文件 (LESS、SASS、CoffeeScript) ，以及语言包。其中包含三个目录: `assets`, `lang`, 和 `views`。

        > `views` 目录包含了视图模板文件, 一共两个,分别是安装页面和正常页面

        > `assets` 目录包含了前端原始的静态资源文件, **我们的Vue组件编写也会在这里**

        > `lang` 目录为语言包目录, 暂时不需要关注

    - `routes` 目录

        > `routes` 目录包含了应用的所有路由定义。

        > `web.php` 文件里定义的路由会在 `RouteServiceProvider` 中被指定应用到 `app.web` 或 `app.install` 中间件组，具备 开启 Session 、CSRF 防护（TODO）以及 Cookie 加密等功能。

        > `api.php` 文件里定义的路由会在 `RouteServiceProvider` 中被指定应用到 `app.api` 或 `app.install` 中间件组，具备 开启 Session 、CSRF 防护（TODO），Cookie 加密 ，身份验证，权限验证 以及 频率限制等功能。

        > `console.php` 文件用于定义所有基于闭包的控制台命令，每个闭包都被绑定到一个控制台命令并且允许与命令行 IO 方法进行交互，尽管这个文件并不定义 HTTP 路由，但是它定义了基于命令行的应用入口（路由）。

        > `channels.php` 不清楚，暂时不需要关注

    - `storage` 目录

        > `storage` 目录包含编译后的 Blade 模板、基于文件的 session、文件缓存和其它框架生成的文件。此文件夹分成 `app` 、`framework` ，及 `logs` 目录。

        > `storage/app` 目录可用于存储应用程序使用的任何文件。其下有一个特殊的文件,叫做 `installed.lock` ,表示系统已经完成了初始化.

        > `framework` 目录被用于保存框架生成的文件及缓存。

        > `logs` 目录包含了应用程序的日志文件。

        > `storage/app/public` 可以用来存储用户生成或上传的文件，这是一个公开的目录。

    - `tests` 目录

        > `tests` 目录包含自动化测试。

    - `vendor` 目录

        > `vendor` 目录包含所有 Composer 依赖。

- 根目录\app目录

    > 应用的核心代码位于 `app` 目录下，默认情况下，该目录位于命名空间 `App` 下， 并且被 Composer 通过 PSR-4 自动载入标准 自动加载。

    - `Console` 目录

        > `Console` 目录包含应用所有自定义的 Artisan 命令，这些命令类可以使用 `make:command` 命令生成。该目录下还有 Console Kernel 类，在这里可以注册自定义的 Artisan 命令以及定义调度任务。

    - `Events` 目录

        > `Events` 目录默认不存在，它会在你使用 `event:generate` 或者 `event:make` 命令以后才会生成。如你所料，此目录是用来放置 [事件类](https://docs.golaravel.com/docs/5.4/events/) 的。事件类用于当指定事件发生时，通知应用程序的其它部分，并提供了很棒的灵活性及解耦。

    - `Exceptions` 目录

        > `Exceptions` 应用的异常处理，同时还是处理应用抛出的任何异常的好位置。如果你想自定义异常的记录和渲染，你应该修改此目录下的 `Handler` 类。

    - `Http` 目录

        > `Http` 目录包含了控制器、中间件以及表单请求等，几乎所有进入应用的请求处理都在这里进行。

    - `Jobs` 目录

         > `Jobs` 目录默认不存在，可以通过执行 `make:job` 命令生成，`Jobs` 目录用于存放 队列任务，应用中的任务可以推送到队列，也可以在当前请求生命周期内同步执行。同步执行的任务有时也被看作命令，因为它们实现了 [命令总线设计模式](https://en.wikipedia.org/wiki/Command_pattern)。

    - `Listeners` 目录

        > `Listeners` 目录默认不存在，可以通过执行 `event:generate` 和 `make:listener` 命令创建。`Listeners` 目录包含处理 [事件](https://docs.golaravel.com/docs/5.4/events/) 的类（事件监听器），事件监听器接收一个事件并提供对该 事件发生后的响应逻辑，例如，`UserRegistered` 事件可以被 `SendWelcomeEmail` 监听器处理。

    - `Mail` 目录

        > `Mail` 目录默认不存在，但是可以通过执行 `make:mail` 命令生成，`Mail` 目录包含邮件发送类，邮件对象允许你在一个地方封装构建邮件所需的所有业务逻辑，然后使用 `Mail::send` 方法发送邮件。

    - `Notifications` 目录

        > `Notifications` 目录默认不存在，你可以通过执行 `make:notification` 命令创建， `Notifications` 目录包含应用发送的所有通知，比如事件发生通知。Laravel 的通知功能将通知发送和通知驱动解耦，你可以通过邮件，也可以通过 Slack、短信或者数据库发送通知。

    - `Policies` 目录

        > `Policies` 你可以通过执行 `make:policy` 命令来创建， `Policies` 目录包含了所有的授权策略类，策略用于判断某个用户是否有权限去访问指定资源。更多详情，请查看 [授权文档](https://docs.golaravel.com/docs/5.4/authorization/)。

    - `Providers` 目录

        > `Providers` 目录包含应用的 [服务提供者](https://docs.golaravel.com/docs/5.4/providers/) 。服务提供者在启动应用过程中绑定服务到容器、注册事件，以及执行其他任务，为即将到来的请求处理做准备。



- `resources/assets` 目录

    > `resources` 目录包含了视图、原始的资源文件 (LESS、SASS、CoffeeScript) ，以及语言包。

    > `assets` 目录包含了所有前端原始的静态资源文件

    - `images` 目录

        > `images` 目录包含了全站所有的图片资源, 前端所有用到的图片资源需要全部放到这个目录进行统一管理, 这个目录下的图片资源最终经过编译会放到 `public/images` 目录下

    - `js` 目录

        > `js` 目录, 存放全站所有的js资源

    - `js\admin` 后台管理目录  
        admin目录是一个 spa 项目，由 webpack 来管理
        应用结构:

        ```
        admin 目录
            app.js              webpack 入口，生成 spa 应用的 Vue 实例
            app.vue             spa 的根组件，是整个 spa 应用的容器
            routes/routes.js    spa 应用的路由配置文件
            bus.js              一个独立的 Vue 实例，作为 EventBus 来使用，用于跨组件的事件传递
            pages
                login.vue       页面型组件，需要登录时展示
                dashboard.vue   页面型组件，已登录且存在匹配的路由时展示，内部嵌套地展示 components 目录下的子组件
                403.vue         页面型组件，已登录且存在匹配的路由，但当前用户无权限访问该路由时展示（TODO）
                404.vue         页面型组件，无路由匹配时展示
            components 目录，非页面型组件都在这个目录下
                example 目录, 
                layout 目录, 布局相关的子组件
                    error.vue           错误页面
                    index.vue           系统首页 
                    left-menu.vue       左侧菜单树组件
                    visited-tabs.vue    最近（10条）访问过的页面历史记录
                    refresh.vue         伪刷新当前页面的辅助组件
                shared 目录，可供多个子组件共享的子组件
                    img-preview.vue     点击图片时弹窗展示图片
            filters 目录,自定义的 VueFilter
                index.js    提供各种自定义的 VueFilter
            utils 目录
            store 目录
            api
                auth.js    系统的权限管理相关的 api
                index.js   
                example.js 系统的示例相关的 api
                user.js    系统的用户登录登出相关的 api
        ```
    - `js\install` 系统的安装相关功能的目录  
         `install` 目录也是一个 spa 项目,应用结构与 `admin` 类似,此处略过
        ​        