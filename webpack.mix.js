const { mix } = require('laravel-mix');

mix
    .js('resources/assets/js/admin/app.js', 'public/js/app.js')
    .js('resources/assets/js/install/app.js', 'public/js/install.js')
    // 抽离不会变的js模块
    .extract(
        ['axios', 'js-cookie', 'lockr', 'lodash', 'nprogress', 'vue', 'vue-router', 'element-ui', 'vue-echarts-v3', 'vue-quill-editor'],
        'public/js/vendor.js'
    )
    // 加载通用样式
    .styles(
        [
            'node_modules/element-ui/lib/theme-default/index.css',
            'resources/assets/css/global.css'
        ],
        'public/css/app.css'
    )
    // 复制element-ui的字体文件
    .copy('node_modules/element-ui/lib/theme-default/fonts', 'public/css/fonts/')
    .webpackConfig({
        resolve: {
            extensions: ['.js', '.vue', '.json'],
            'alias':{
                'appComponentPath': path.resolve(__dirname, 'resources/assets/js/admin/components'),
            }
        }
    })
    .version()
    // .browserSync({
    //     url: 'http://laravel-spa-admin.local'
    // })
;


