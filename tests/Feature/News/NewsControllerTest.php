<?php

declare(strict_types=1);

use Database\Seeders\CategorySeeder;
use Database\Seeders\NewsSeeder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Category\Infrastructure\Models\Category;
use Src\News\Infrastructure\Models\News;

it('cadastra uma noticia com sucesso', function (): void {
    $category = Category::factory()->create();

    $response = $this->post(route('news.store'), [
        'title' => 'Nova integracao no backend da plataforma',
        'content' => 'Conteudo da noticia com detalhes suficientes para passar pela validacao.',
        'excerpt' => 'Resumo objetivo da noticia.',
        'category_id' => $category->id,
    ]);

    $response
        ->assertRedirect(route('news.create'))
        ->assertSessionHas('success', 'Notícia cadastrada com sucesso.');

    $this->assertDatabaseHas('news', [
        'title' => 'Nova integracao no backend da plataforma',
        'category_id' => $category->id,
    ]);
});

it('valida os campos obrigatorios de noticia', function (): void {
    $response = $this
        ->from(route('news.create'))
        ->post(route('news.store'), [
            'title' => 'Oi',
            'content' => 'Curto',
            'category_id' => 9999,
        ]);

    $response
        ->assertRedirect(route('news.create'))
        ->assertSessionHasErrors([
            'title' => 'O título da notícia deve ter pelo menos 3 caracteres.',
            'content' => 'O conteúdo da notícia deve ter pelo menos 10 caracteres.',
            'category_id' => 'A categoria informada não existe.',
        ]);

    $this->assertDatabaseCount('news', 0);
});

it('lista noticias na tela inicial com dados seedados', function (): void {
    $this->seed([
        CategorySeeder::class,
        NewsSeeder::class,
    ]);

    $response = $this->get(route('news.index'));

    $response
        ->assertOk()
        ->assertViewIs('news.index')
        ->assertViewHas('newsItems', function (LengthAwarePaginator $newsItems): bool {
            return $newsItems->total() === 50
                && count($newsItems->items()) === 10;
        });
});

it('busca noticias por titulo', function (): void {
    $category = Category::factory()->create();

    News::factory()->create([
        'title' => 'Laravel organiza modulos do backend',
        'category_id' => $category->id,
    ]);

    News::factory()->create([
        'title' => 'Mercado acompanha alta do setor financeiro',
        'category_id' => $category->id,
    ]);

    $response = $this->get(route('news.index', [
        'title' => 'Laravel organiza',
    ]));

    $response
        ->assertOk()
        ->assertViewHas('newsItems', function (LengthAwarePaginator $newsItems): bool {
            $items = collect($newsItems->items());

            return $newsItems->total() === 1
                && $items->first()?->title === 'Laravel organiza modulos do backend';
        });
});

it('busca noticias por categoria', function (): void {
    $technology = Category::factory()->create([
        'name' => 'Tecnologia',
        'slug' => 'tecnologia',
    ]);

    $sports = Category::factory()->create([
        'name' => 'Esportes',
        'slug' => 'esportes',
    ]);

    News::factory()->create([
        'title' => 'Plataforma amplia cobertura de software',
        'category_id' => $technology->id,
    ]);

    News::factory()->create([
        'title' => 'Clube anuncia reforco para o campeonato',
        'category_id' => $sports->id,
    ]);

    $response = $this->get(route('news.index', [
        'category_id' => $technology->id,
    ]));

    $response
        ->assertOk()
        ->assertViewHas('newsItems', function (LengthAwarePaginator $newsItems) use ($technology): bool {
            $items = collect($newsItems->items());

            return $newsItems->total() === 1
                && $items->first()?->category_id === $technology->id;
        });
});
