<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->environment() !== 'production') {
            Route::get('logs', ['uses'=>'\Rap2hpoutre\LaravelLogViewer\LogViewerController@index','meta' => ['description' => '查看系统日志（仅开发环境!）']])->name('app.logs');
        }

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if(is_app_installed()){
            $this->mapRoutesForApp();
        }else{
            $this->mapRoutesForInstall();
        }

    }

    protected function mapRoutesForApp()
    {
        Route::middleware('app.api')->namespace($this->namespace)->group(base_path('routes/api.php'));

        Route::middleware('app.web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    protected function mapRoutesForInstall(){
        Route::middleware('install.api')->namespace($this->namespace)->group(base_path('routes/api.php'));

        Route::middleware('install.web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }
}
