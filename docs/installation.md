# Laravel-SPA-Admin 项目的开发环境安装手册

## 更新日志
- 更新时间： 2017-09-17  - 更新人员： 胡中园

## 下载项目源码
 代码地址： 

## 解压项目源码
 解压到你的 web 服务器支持的目录

## 安装
- 安装 nodejs 并添加到环境变量，版本要求： >= 8.0

- 安装 composer 并添加到环境变量 ， 版本要求： >= 1.5.1

- 安装 php 并添加到环境变量， php 版本要求： >= 7.0

- 安装 nodejs 的全局依赖
  - 安装 nrm ,用于快速切换 npm 的 registry  
    任意位置打开 cmd 窗口，输入： 
    ```bash
    npm install -g nrm --verbose
    ```
  - 配置 npm 的源为 taobao 的源,以提高下载速度  
    任意位置打开 cmd 窗口，输入： 
    ```bash
    nrm use taobao
    ```
  - 安装 node-gyp ,用于编译 node 的二进制依赖  
    任意位置打开 cmd 窗口，输入： 
      ```bash
      npm install -g node-gyp --verbose
      ```
  - 安装 npm-check ,用于快速检查和更新当前项目的依赖(可选)  
    任意位置打开 cmd 窗口，输入： 
      ```bash
      npm install -g npm-check --verbose
      ```

- 安装项目的 nodejs 依赖  
  切换到项目根目录下，打开 cmd 窗口，输入： 
    ```bash
    npm install --verbose --sass-binary-site=http://npm.taobao.org/mirrors/node-sass
    ```

- 安装项目的 php 依赖  
    切换到项目根目录下，打开 cmd 窗口，输入： 
    ```bash
    composer config -g repo.packagist composer https://packagist.phpcomposer.com
    composer install -vvv
    ```
    然后,将第三方 ServiceProvider 的 assets (配置文件,模板文件等) 发布到项目中
    ```php
    php artisan vendor:publish
    ```

## 设置开发环境
- Web 服务器设置
  -   添加一个新的 vhost ，vhost 的 root 目录需设置到项目的 public 目录

- phpstorm 设置
  - 在 phpstorm/settings/plugins 中安装以下 plugin：
    - Vue ，用于 .vue 文件的语法高亮和代码提示
    - Laravel ，用于 laravel 框架的代码提示

  - 在 phpstorm/settings/editor/inspections 设置中，取消勾选 `File watcher available` 和 `File watcher problems` , 即关闭 phpstorm 自带的 FileWatcher 的功能，以免和 webpack 的热更新机制冲突

  - 当第一次打开项目的 js文件时, phpstorm 会提示 js 的语法错误，此时点击 phpstorm/settings/language-and-frameworks/javascript ， 设置 js 语法检查的 version 为 ECMAScript 6

  - 检查项目根目录下是否存在 .env 文件，如果不存在，请将根目录下的 .env.example 复制为 .env

  - 检查你的 .env 文件中的 APP_KEY 是否有值，如果为空，则切换到项目根目录下，打开 cmd 窗口，输入： 
    ```bash
    php artisan key:generate
    ```

  - 根据你的本地环境，自行修改 .env 文件中的其他配置，如数据库的用户名和密码等

  - 为优化 js 代码导航，可以在 phpstorm 中的 public/js 目录上点击右键，在 MarkDirectoryAs 中选择 Excluded 

## 初次运行项目
- 切换到项目根目录下，打开 cmd 窗口，输入： 
    ```bash
    npm run dev
    ```
    此命令将会把我们编写的组件转换成浏览器可识别的 js，css 等文件，并打包到 public 目录下

## 初始化系统
- 在浏览器中输入你设置的 serverName, 如 http://laravel-spa-admin.local/ 
- 正常情况下，你会看到一个登录页面,并提示你需要初始化系统
- 切换到项目根目录下，打开 cmd 窗口，输入： 
    ```bash
    php artisan app:install
    ```
    此命令将会生成一个60分钟后自动失效的 installer 账号,installer 账号的登录名和登录密码会在命令行的输出结果中展示  
    使用这个 installer 账号登录,在页面的引导下,完成系统的初始化操作,如系统菜单的初始化,创建第一个角色,创建第一个用户等  
    初始化完成之后,点击页面中的 "初始化结束" 按钮, 或者在 cmd 窗口中手动输入 `php artisan app:installed`,即可正式开始使用
- 备注: 理论上, installer  账号可以创建任意多个角色和用户,但是,建议 installer 账号在系统初始化时仅创建一个管理员角色和一个管理员用户,然后给这个管理员分配创建其他角色和用户的权限即可        
- 备注2: 系统安装完成后,可在 phpstorm 中的 resource/assets/js/install 目录上点击右键，在 MarkDirectoryAs 中选择 Excluded ,以便优化 js 代码导航

## 开始使用系统
- 再次在浏览器中输入你设置的 serverName, 如 http://laravel-spa-admin.local/
- 正常情况下，你会看到一个新的登录页面
- 使用刚才 installer 账号创建的管理员用户进行登录
- 使用管理员用户创建其他的角色和其他的用户
- 使用系统的其他功能

## 项目开发与调试
前端有不同的命令来支持不同的开发模式：
- `npm run dev` : 将现有的代码打包到 public 目录并退出，浏览器刷新后可看到打包后的效果
- `npm run watch`: 将现有代码打包到 public 目录并在后台运行，当检测到文件有更新时，自动重新打包，浏览器刷新后可看到重新打包后的效果
- `npm run hot`: 将现有代码打包到 public 目录并在后台运行，并启动一个代理服务，当检测到 vue 组件有更新时，自动更新页面上相关的组件，无需刷新页面
- `npm run prod`: 将现有的代码打包到 public 目录并退出，该过程相比 `npm run dev` 耗时更长，因为需要进行一些压缩和优化
- `npm run development`: 同 `npm run dev`
- `npm run production`: 同 `npm run prod`

后端的调试：
- xdebug.dll + storage/logs/laravel.log
- 非生产环境下,可以访问 http://your.project.domain/logs 来查看 laravel.log

前端的调试:
-   使用 chrome 浏览器，并安装 [vuejs-devtools 插件](https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd) ，安装成功后，打开浏览器调试台，可在 vue 选项卡中看到应用的路由，组件，状态等信息

## Enjoy!
