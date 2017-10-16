<?php

namespace Tests\Feature;

use App\Http\ResponseCodes;
use Tests\AppTestCase;

class SyncTest extends AppTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function sync_should_success_if_user_has_logged_in()
    {
        $response = $this
            ->actAsAdmin()
            ->postJson('/api/session/sync');

        $response->assertJson([
            'code'    => ResponseCodes::SUCCESS,
            'message' => '请求成功',
            'data'    => [
                'user'   => [
                    'username' => 'admin',
                    'roles'    => [],
                    'menus'    => [],
                    'apis'     => [],
                    'routes'   => [],
                ],
                'system' => [
                    'roles' => [],
                    'menus' => [],
                    'apis'  => [],
                ],
            ],
        ])->assertJsonStructure([
            'code',
            'message',
            'data' => [
                'user'   => [
                    'username',
                    'roles',
                    'menus'  => [
                        '*' => [
                            'name',
                            'type',
                            'path',
                            'parent',
                            'selected',
                        ],
                    ],
                    'apis'   => [
                        '*' => [
                            'description',
                            'uri',
                        ],
                    ],
                    'routes' => [
                        '*' => [
                            'name',
                            'path',
                        ],
                    ],
                ],
                'system' => [
                    'roles' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'display_order',
                            'routes',
                            'menus',
                            'apis',
                            'is_disabled',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                        ],
                    ],
                    'menus' => [
                        '*' => [
                            'name',
                            'type',
                            'path',
                            'parent',
                          //  'children',
                        ],
                    ],
                    'apis'  => [
                        '*' => [
                            'description',
                            'uri',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function sync_should_fail_if_user_session_expired()
    {
        $response = $this->postJson('/api/session/sync', []);

        $response->assertExactJson([
            'code'    => ResponseCodes::NOT_AUTHENTICATED,
            'message' => '您未登录或会话已过期',
            'data'    => [],
        ]);
    }
}
