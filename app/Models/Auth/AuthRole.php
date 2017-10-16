<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 15:45
 */

namespace App\Models\Auth;


use App\Models\AppModel;

class AuthRole extends AppModel
{
    protected $table = 'auth_roles';

    /**
     * 角色关联的用户
     */
    public function users()
    {
        return $this->belongsToMany(AuthUser::class,'auth_role_user');
    }
}