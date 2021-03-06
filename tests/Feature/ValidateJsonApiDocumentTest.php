<?php

namespace Tests\Feature;


use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiDocumentTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Route::any('test_route',function (){
            return 'OK';
        })->middleware(ValidateJsonApiDocument::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_is_required()
    {
        $this->postJson('test_route',[])
            ->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route',[])
            ->assertJsonApiValidationErrors('data');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_must_be_an_array()
    {
        $this->postJson('test_route',[
            'data'=>'I am an string'
        ])->assertJsonApiValidationErrors('data');

        $this->patchJson('test_route',
            ['data'=>'I am an string'])
            ->assertJsonApiValidationErrors('data');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_type_is_required()
    {
        $this->postJson('test_route',[
            'data'=>[
                'attributes'=>[]
            ]
        ])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route',
            [
                'data'=>[
                    'attributes'=>['text']
                ]
            ])
            ->assertJsonApiValidationErrors('data.type');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_type_must_be_a_string()
    {
        $this->postJson('test_route',[
            'data'=>[
                'type'=>1,
                'attributes'=>['text']
            ]
        ])->assertJsonApiValidationErrors('data.type');

        $this->patchJson('test_route',
            [
                'data'=>[
                    'type'=>false,
                    'attributes'=>['text']
                ]
            ])
            ->assertJsonApiValidationErrors('data.type');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_attribute_is_required()
    {
        $this->postJson('test_route',[
            'data'=>[
                'type'=>'string',
            ]
        ])->assertJsonApiValidationErrors('data.attributes');

        $this->patchJson('test_route',
            [
                'data'=>[
                    'type'=>'string'
                ]
            ])
            ->assertJsonApiValidationErrors('data.attributes');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_attribute_must_be_an_array()
    {
        $this->postJson('test_route',[
            'data'=>[
                'type'=>'string',
                'attributes'=>'string'
            ]
        ])->assertJsonApiValidationErrors('data.attributes');

        $this->patchJson('test_route',
            [
                'data'=>[
                    'type'=>'string',
                    'attributes'=>'string'
                ]
            ])
            ->assertJsonApiValidationErrors('data.attributes');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_id_is_required()
    {
        $this->patchJson('test_route',
            [
                'data'=>[
                    'type'=>'string',
                    'attributes'=>['string']
                ]
            ])
            ->assertJsonApiValidationErrors('data.id');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function data_id_must_be_a_string()
    {
        $this->patchJson('test_route',
            [
                'data'=>[
                    'id'=>1,
                    'type'=>'string',
                    'attributes'=>['string']
                ]
            ])
            ->assertJsonApiValidationErrors('data.id');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     *  @test
     */
    public function only_accepts_valid_json_api_documents()
    {
        $this->postJson('test_route',
            [
                'data'=>[
                    'type'=>'string',
                    'attributes'=>['string']
                ]
            ])
            ->assertSuccessful();

        $this->patchJson('test_route',
            [
                'data'=>[
                    'id'=>'1',
                    'type'=>'string',
                    'attributes'=>['string']
                ]
            ])
            ->assertSuccessful();
    }
}
