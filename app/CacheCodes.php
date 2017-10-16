<?php
/**
 * Created by PhpStorm.
 * User: cools
 * Date: 2017/9/15 0015
 * Time: 11:51
 */

namespace App;

/**
 * Cache 的 key 和默认过期时间管理
 *
 * @package app
 */
class CacheCodes
{
    /**
     * 保存了由 php artisan app:install 命令生成的 installer 账号信息
     * 存储类型为数组
     */
    const APP_INSTALLER_ACCOUNT = ['store'=> 'file' ,'key' => 'app:installer:account', 'expire' => 60 ];
}