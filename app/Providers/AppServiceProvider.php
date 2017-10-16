<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mews\Captcha\Captcha;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if ($this->app->environment() !== 'production') {
            // pass
        }

        // Note: 此处手动注册 captcha ,而不是使用该 captcha 自带的 ServiceProvider 的 register 方法来注册,
        // 是因为自带的 ServiceProvider 中的 register 写的有问题:其强制添加一条路由到系统中,并且强制为该路由指定一个名为 web 的中间件,不满足我们项目的要求,且不符合 ServiceProvider 的规范
        $this->app->bind('captcha', function($app)
        {
            return new Captcha(
                $app['Illuminate\Filesystem\Filesystem'],
                $app['Illuminate\Config\Repository'],
                $app['Intervention\Image\ImageManager'],
                $app['Illuminate\Session\Store'],
                $app['Illuminate\Hashing\BcryptHasher'],
                $app['Illuminate\Support\Str']
            );
        });
    }
}
