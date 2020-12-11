<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginateArticleTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function cant_fetch_paginated_articles()
    {
    	$articles = Article::factory(10)->create();
    	$url = route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 3]);
    	$response = $this->getJson($url);
    	$assertView = $response->assertJsonCount(2, 'data');

    	foreach ($articles as $key => $article) {
    		if($key === 4 || $key === 5) {
    			$assertView->assertSee($article->title);
    		}
    		else {
    			$assertView->assertDontSee($article->title);
    		}
    	}
    	$response->assertJsonStructure([
    		'links' => ['first', 'last', 'prev', 'next']
    	]);

    	$response->assertJsonFragment([
    		'first' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 1]),
    		'last' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 5]),
    		'prev' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 2]),
    		'next' => route('api.v1.articles.index', ['page[size]' => 2, 'page[number]' => 4])
    	]);

    }
}
