<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListArticleTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_fetch_single_article()
    {
    	$article = Article::factory()->create();
    	$response = $this->getJson(route('api.v1.articles.show', $article));
    	$response->assertExactJson([
    		'data' => [
    			'type' => 'articles',
    			'id'  => (string) $article->getRouteKey(),
    			'attributes' => [
    				'title' => $article->title,
    				'slug' => $article->slug,
    				'content' => $article->content,
    			],
    			'links' => [
    				'self' => url(route('api.v1.articles.show',$article)),
    			]
    		]
    	]);
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_fetch_all_articles()
    {
        $articles = Article::factory(10)->create();
        $response = $this->getJson(route('api.v1.articles.index'));
        foreach ($articles as $key => $article) {
            $data[] = [
                'type' => 'articles',
                'id'  => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [
                    'self' => url(route('api.v1.articles.show',$article)),
                ]
            ];
        }
        $response->assertExactJson([
            'data' => $data,
            'self' => [
                'links' => route('api.v1.articles.index')
            ],
            'meta' => [
                'ArticleCount' => count($articles)
            ]
        ]);
    }
  }
