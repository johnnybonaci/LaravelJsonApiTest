<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortArticleTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_sort_articles_by_title_asc()
    {
    	Article::factory()->create(['title' => 'D Title']);
    	Article::factory()->create(['title' => 'B Title']);
    	Article::factory()->create(['title' => 'C Title']);
    	Article::factory()->create(['title' => 'A Title']);
    	$response = $this->getJson(route('api.v1.articles.index',['sort=title']));
    	$response->assertSeeInOrder([
    		'A Title',
    		'B Title',
    		'C Title',
    		'D Title'
    	]);
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_sort_articles_by_title_desc()
    {
    	Article::factory()->create(['title' => 'D Title']);
    	Article::factory()->create(['title' => 'B Title']);
    	Article::factory()->create(['title' => 'C Title']);
    	Article::factory()->create(['title' => 'A Title']);
    	$response = $this->getJson(route('api.v1.articles.index',['sort=-title']));
    	$response->assertSeeInOrder([
    		'D Title',
    		'C Title',
    		'B Title',
    		'A Title',
    	]);
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_sort_articles_by_title_and_content()
    {
        Article::factory()->create([
            'title' => 'D Title',
            'content' => 'A content'
        ]);
        Article::factory()->create([
            'title' => 'B Title',
            'content' => 'C content'
        ]);
        Article::factory()->create([
            'title' => 'C Title',
            'content' => 'D content'
        ]);
        Article::factory()->create([
            'title' => 'A Title',
            'content' => 'B content'
        ]);
        $response = $this->getJson(route('api.v1.articles.index', ['sort' => 'title,-content']));
        $response->assertSeeInOrder([
            'A Title',
            'B Title',
            'C Title',
            'D Title'
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function it_cannot_sort_articles_by_unknow_fields()
    {
        Article::factory()->create(['title' => 'D Title']);
        Article::factory()->create(['title' => 'B Title']);
        Article::factory()->create(['title' => 'C Title']);
        Article::factory()->create(['title' => 'A Title']);
        $response = $this->getJson(route('api.v1.articles.index',['sort=unknow']));
        $response->assertStatus(400);
    }
}
