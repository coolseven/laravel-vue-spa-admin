<?php

namespace App\Console\Commands;

use App\CacheCodes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install or repair the app';

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
        $confirmed = $this->confirm('This command will block any existing user\'s requests until you have finished installing, are you sure to continue?' ,false);

        if (!$confirmed) {
            $this->info('cancelled');
            return;
        }

        $this->info('Removing any previous installation lock...');
        $this->removePreviousInstallationLock();
        $this->line('done');

        $this->info('Removing any previous installer account...');
        $this->removePreviousInstallerAccount();
        $this->line('done');

        $this->info('Generating an installer account...');
        $installer = $this->generateInstallerAccount();
        $this->line('done');


        $this->displayInstallationTips($installer);
    }

    private function removePreviousInstallationLock()
    {
        $installation_lock_path = app_installation_lock_path();

        $deleted = true;

        if (Storage::exists($installation_lock_path)) {
            $deleted = Storage::delete($installation_lock_path);
        }

        if (!$deleted) {
            throw new Exception('Failed when removing previous installation lock. Please make sure you have proper permissions on ' . $installation_lock_path);
        }
    }

    private function removePreviousInstallerAccount()
    {
        Cache::store(CacheCodes::APP_INSTALLER_ACCOUNT['store'])->forget(CacheCodes::APP_INSTALLER_ACCOUNT['key']);
    }

    private function generateInstallerAccount()
    {
        $username = Str::random(5);
        $password = Str::random(10);
        $password_encrypted = password_hash($password, PASSWORD_BCRYPT);
        $expires_at = date('M-d H:i' , time() + CacheCodes::APP_INSTALLER_ACCOUNT['expire'] * 60 );

        $installer_cache    = ['username'  => $username, 'password'  => $password_encrypted, 'expires_at' => $expires_at] ;
        $installer_account  = ['username'  => $username, 'password'  => $password, 'expires_at' => $expires_at];

        Cache::store(CacheCodes::APP_INSTALLER_ACCOUNT['store'])->put(CacheCodes::APP_INSTALLER_ACCOUNT['key'],$installer_cache, CacheCodes::APP_INSTALLER_ACCOUNT['expire']);

        return $installer_account;
    }

    private function displayInstallationTips( $installer )
    {
        $this->info('An installer account has been created: ');

        $headers = ['url', 'username', 'password', 'expired_at'];
        $rows = [
            [
                'url'           => app_index_url().'/login',
                'username'      => $installer['username'],
                'password'      => $installer['password'],
                'expires_at'    => $installer['expires_at'],
            ],
        ];
        $this->table($headers, $rows);

        $this->info('Now you can login with the account above to install your app');

        $this->info('Don\'t forget to run php artisan app:installed when you have finished installing!');
    }
}
