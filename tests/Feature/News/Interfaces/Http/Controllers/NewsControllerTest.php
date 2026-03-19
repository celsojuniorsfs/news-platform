<?php

declare(strict_types=1);

namespace Tests\Feature\News\Interfaces\Http\Controllers;

use Src\Category\Infrastructure\Models\Category;
use Src\News\Infrastructure\Models\News;
use Tests\TestCase;

final class NewsControllerTest extends TestCase
{
    public function test_news_index_returns_view(): void
    {
        $response = $this->get(route('news.index'));

        $response->assertStatus(200);
        $response->assertViewIs('news.index');
    }

    public function test_store_news_validates_required_fields(): void
    {
        $response = $this->post(route('news.store'), []);

        $response->assertSessionHasErrors(['title', 'content', 'category_id']);
    }

    public function test_store_news_creates_successfully(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('news.store'), [
            'title' => 'Test News Title',
            'content' => 'This is a test news content with enough characters',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('news.index'));
        $response->assertSessionHas('success', 'Notícia cadastrada com sucesso.');

        $this->assertDatabaseHas('news', [
            'title' => 'Test News Title',
            'content' => 'This is a test news content with enough characters',
            'category_id' => $category->id,
        ]);
    }

    public function test_search_news_filters_by_title(): void
    {
        $category = Category::factory()->create();
        News::factory()->create([
            'title' => 'Laravel Tips',
            'category_id' => $category->id,
        ]);
        News::factory()->create([
            'title' => 'PHP Basics',
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('news.index', ['title' => 'Laravel']));

        $response->assertStatus(200);
        $response->assertViewHas('newsItems', function ($newsItems) {
            return $newsItems->count() === 1 && $newsItems->first()->title === 'Laravel Tips';
        });
    }

    public function test_search_news_filters_by_category(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        News::factory()->create(['category_id' => $category1->id]);
        News::factory()->create(['category_id' => $category2->id]);

        $response = $this->get(route('news.index', ['category_id' => $category1->id]));

        $response->assertStatus(200);
        $response->assertViewHas('newsItems', function ($newsItems) {
            return $newsItems->count() === 1 && $newsItems->first()->category_id === $category1->id;
        });
    }
}

