<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 15:45
 */

namespace App\Models\Auth;


use App\Models\AppModel;

class AuthUser extends AppModel
{
    protected $table = 'auth_users';

    protected $hidden = ['password'];

    /**
     * 属于该用户的身份。
     */
    public function roles()
    {
        return $this->belongsToMany(AuthRole::class ,'auth_role_user');
    }
}