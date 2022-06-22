<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Route::any('test_route',function (){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function accept_header_must_be_present_in_all_requests()
    {

         $this->get('test_route',[
             'accept'=>'application/vnd.api+json'
         ])->assertSuccessful();

    }

    /**
     *  @test
    */
    public function header_content_type_must_be_present_on_all_posts_requests()
    {


        $this->post('test_route',[],[
            'accept'=>'application/vnd.api+json',
        ])->assertStatus(415);

        $this->post('test_route',[],[
            'accept'=>'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertSuccessful();

    }

    /**
     *  @test
     */
    public function header_content_type_must_be_present_on_all_patches_requests()
    {

        $this->patch('test_route',[],[
            'accept'=>'application/vnd.api+json'
        ])->assertStatus(415);

        $this->patch('test_route',[],[
            'accept'=>'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertSuccessful();

    }
    /** @test */
    public function content_type_header_must_be_present_in_responses(){

        $this->get('test_route',[
            'accept'=>'application/vnd.api+json'
        ])->assertHeader('content-type','application/vnd.api+json');

    }
    /** @test */
    public function content_type_header_must_not_be_present_in_empty_responses(){
        Route::any('empty_response', function () {
            return response()->noContent();
        })->middleware(ValidateJsonApiHeaders::class);

        $this->get('empty_response',[
            'accept'=>'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

    }
}