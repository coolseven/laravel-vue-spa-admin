<?php

namespace Tests\Feature;

use App\Http\ResponseCodes;
use Illuminate\Support\Str;
use Tests\AppTestCase;

class HtmlRequestTest extends AppTestCase
{
    /**
     * @var string
     */
    protected $whatever_uri = '';

    public function setUp()
    {
        parent::setUp();
        $this->whatever_uri = route('app',['else' => Str::random(10)]);
    }
    
    /**
     * @test
     *
     * A basic test example.
     *
     * @return void
     */
    public function when_we_expects_html_it_always_receives_html_response_of_the_same_content_for_whatever_uri()
    {
        $headers = [
            'ACCEPT'    => 'text/html',
        ];
        $response = $this->get($this->whatever_uri,$headers);

        $response->assertStatus(200)
            ->assertHeader('Content-Type','text/html; charset=UTF-8')
            ->assertViewIs('app')
            ->assertSee('<div id="app">')
            ->assertSee('<script src="/js/app.js')
            ;
    }

    /**
     * @test
     */
    public function when_we_expects_json_but_using_get_method_it_always_receives_json_response_with_api_not_found_message()
    {
        $headers = [
            'ACCEPT'    => 'application/json',
        ];
        $response = $this->get($this->whatever_uri,$headers);

        $response->assertStatus(200)
            ->assertHeader('Content-Type','application/json')
            ->assertJson([
                'code'  => ResponseCodes::API_NOT_FOUND,
                'message'   => '接口不存在或地址不正确',
            ]);
    }
}
