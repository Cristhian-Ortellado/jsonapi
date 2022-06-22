<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function can_create_articles()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertCreated();

        $article = Article::first();

        $response->assertHeader('Location', route('api.v1.articles.show', $article));

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string)$article->getRouteKey(),
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]

            ]
        ]);


    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function title_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonValidationErrors(['data.attributes.title']);

    }


    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function title_must_be_at_least_4_characters()
    {

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'oli',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonValidationErrors(['data.attributes.title']);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function slug_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonValidationErrors(['data.attributes.slug']);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function content_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                ]
            ]
        ]);

        $response->assertJsonValidationErrors(['data.attributes.content']);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function verify_error_structure()
    {

        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'slug' => 'nuevo-articulo',
                    'content'=>'Contenido del articulo'
                ]
            ]
        ]);

        $response->assertJsonStructure([
            'errors'=>[
                '*'=>[
                    'title', 'detail', 'source' => ['pointer']
                ]
            ]
        ])->assertJsonFragment([
            'source'=>['pointer'=>'/data/attributes/title']
        ])->assertHeader(
            'content-type','application/vnd.api+json'
        )->assertStatus(422);

    }
}
