<?php

namespace App\Console;

use App\Console\Commands\AppInstall;
use App\Console\Commands\AppInstalled;
use App\Jobs\Cron\QueueLivedChecker;
use App\Jobs\Cron\ProviderEmployeeCreditStatistics;
use App\Jobs\Cron\UpdateActivityStatus;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AppInstall::class,
        AppInstalled::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // 定时任务
        // 检测队列监听定时任务 (队列监听的定时任务不能使用队列, 否则队列监听挂掉后也就不能执行了)
        $schedule->call(function(){
            QueueLivedChecker::run();
        })->everyMinute();

        // 员工积分统计
        $schedule->job(ProviderEmployeeCreditStatistics::class)->daily();
        $schedule->job(UpdateActivityStatus::class)->daily();

        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
