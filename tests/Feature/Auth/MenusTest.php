<?php

namespace Tests\Feature\Auth;

use App\Http\ResponseCodes;
use App\Services\SystemService;
use Tests\AppTestCase;

class MenusTest extends AppTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function system_menus_should_be_json()
    {
        $response = $this->actAsAdmin()
            ->postJson('/api/auth/menus/all');

        $expect_menus_array = json_decode( json_encode(SystemService::getMenusTree() ) ,true) ;

        $response->assertJson([
            'code'    => ResponseCodes::SUCCESS,
            'message' => '请求成功',
            'data'    => $expect_menus_array,
        ]);
    }
}
