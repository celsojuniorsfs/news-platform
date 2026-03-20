<?php

declare(strict_types=1);

use Src\Category\Infrastructure\Models\Category;

it('cadastra uma categoria com sucesso', function (): void {
    $response = $this
        ->from(route('categories.index'))
        ->post(route('categories.store'), [
            'name' => 'Cobertura Especial',
        ]);

    $response
        ->assertRedirect(route('categories.index'))
        ->assertSessionHas('success', 'Categoria cadastrada com sucesso.');

    $this->assertDatabaseHas('categories', [
        'name' => 'Cobertura Especial',
        'slug' => 'cobertura-especial',
    ]);
});

it('bloqueia o cadastro de categoria duplicada', function (): void {
    Category::factory()->create([
        'name' => 'Tecnologia',
        'slug' => 'tecnologia',
    ]);

    $response = $this
        ->from(route('categories.index'))
        ->post(route('categories.store'), [
            'name' => 'Tecnologia',
        ]);

    $response
        ->assertRedirect(route('categories.index'))
        ->assertSessionHasErrors([
            'name' => 'Já existe uma categoria com esse nome.',
        ]);

    expect(Category::query()->count())->toBe(1);
});
