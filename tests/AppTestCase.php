<?php
/**
 * Created by PhpStorm.
 * User: cools
 * Date: 2017/10/12 0012
 * Time: 16:39
 */

namespace Tests;


use App\Models\Auth\AuthUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class AppTestCase extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return $this
     */
    public function actAsAdmin()
    {
        $user_id = (new AuthUser())->where('username' ,'=','admin')->first()->id;

        $this->withSession(['user_id'=>$user_id ,'user_has_logged_in' => true]);

        return $this;
    }
}