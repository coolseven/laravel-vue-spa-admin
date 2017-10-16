<?php

namespace Tests\Feature;

use App\Http\ResponseCodes;
use Illuminate\Support\Facades\Session;
use Tests\AppTestCase;

class LoginTest extends AppTestCase
{
    /**
     * 一个约定好的,固定不变的,用于测试的验证码
     */
    const FAKE_CONSTANT_CAPTCHA = 'dump';

    /**
     * @test
     *
     * @return void
     */
    public function login_should_success_if_right_auth_provided()
    {
        // replace random-generated captcha with our own constant captcha
        $this->get('captcha/easy');
        Session::put('captcha.key', app('hash')->make(self::FAKE_CONSTANT_CAPTCHA));

        $body     = [
            'username' => 'admin',
            'password' => 'aaa',
            'captcha'  => self::FAKE_CONSTANT_CAPTCHA,
        ];
        $response = $this->postJson('/api/user/login', $body);

        $response->assertExactJson([
            'code'    => ResponseCodes::SUCCESS,
            'message' => '登录成功',
            'data'    => [
                'login_success' => true,
            ],
        ]);

        $response->assertSessionHas('user_id');
        $response->assertSessionHas('user_has_logged_in',true);
    }

    /**
     * @test
     */
    public function login_should_fail_if_wrong_captcha_provided()
    {
        $body     = [
            'username' => 'admin',
            'password' => 'aaa',
            'captcha'  => 'wrong',
        ];
        $response = $this->postJson('/api/user/login', $body);

        $response->assertJson([
            'code'    => ResponseCodes::CAPTCHA_MISMATCH,
            'message' => '验证码错误',
        ]);
        $response->assertSessionMissing('user_id');
        $response->assertSessionMissing('user_has_logged_in');
    }

    /**
     * @test
     */
    public function login_should_fail_if_wrong_username_provided()
    {
        // replace random-generated captcha with our own constant captcha
        $this->get('captcha/easy');
        Session::put('captcha.key', app('hash')->make(self::FAKE_CONSTANT_CAPTCHA));

        $body     = [
            'username' => 'admin2',
            'password' => 'aaa',
            'captcha'  => self::FAKE_CONSTANT_CAPTCHA,
        ];
        $response = $this->postJson('/api/user/login', $body);

        $response->assertJson([
            'code'    => ResponseCodes::USERNAME_OR_PASSWORD_MISMATCH,
            'message' => '用户名或密码不正确',
        ]);
        $response->assertSessionMissing('user_id');
        $response->assertSessionMissing('user_has_logged_in');
    }

    /**
     * @test
     */
    public function logout_should_always_success()
    {
        $response = $this->postJson('/api/user/logout', []);

        $response->assertExactJson([
            'code'    => ResponseCodes::SUCCESS,
            'message' => '退出成功',
            'data'    => [
                'session_cleared' => true,
            ],
        ]);

        $response->assertSessionMissing('user_id');
        $response->assertSessionMissing('user_has_logged_in');
    }
}
