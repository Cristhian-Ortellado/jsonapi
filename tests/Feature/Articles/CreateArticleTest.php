<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;


    /**
     * verify if the is possible create articles.
     *
     * @return void
     * @test
     */
    public function can_create_articles()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.v1.articles.store'), [
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
     * verify if the validation for title field is working.
     *
     * @return void
     * @test
     */
    public function title_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonApiValidationErrors('title');

    }


    /**
     * verify if the validation for title field is working.
     *
     * @return void
     * @test
     */
    public function title_must_be_at_least_4_characters()
    {

        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'oli',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonApiValidationErrors('title');

    }

    /**
     * verify if the validation for slug field is working.
     *
     * @return void
     * @test
     */
    public function slug_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'content' => 'Contenido del articulo',
                ]
            ]
        ]);

        $response->assertJsonApiValidationErrors('slug');

    }

    /**
     * verify if the validation for content field is working.
     *
     * @return void
     * @test
     */
    public function content_is_required()
    {

        $response = $this->postJson(route('api.v1.articles.store'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                ]
            ]
        ]);

        $response->assertJsonApiValidationErrors('content');

    }

}
