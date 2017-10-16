<?php

namespace App\Console\Commands;

use App\CacheCodes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class AppInstalled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:installed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark the app as installed when you have installed the app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->removePreviousInstallerAccount();

        $this->generateInstallationLock();

        $this->info('App is now installed.');
    }

    private function removePreviousInstallerAccount()
    {
        Cache::store(CacheCodes::APP_INSTALLER_ACCOUNT['store'])->forget(CacheCodes::APP_INSTALLER_ACCOUNT['key']);
    }

    private function generateInstallationLock()
    {
        $installation_lock_path = app_installation_lock_path();

        $installation_record = [
            'installed_at'  => date('Y-m-d H:i:s'),
        ];

        $created = Storage::put($installation_lock_path , json_encode( $installation_record, JSON_PRETTY_PRINT) );

        if (!$created) {
            throw new Exception('Failed when creating an installation lock. Please make sure you have proper permissions on '. $installation_lock_path);
        }
    }
}
