<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\News\Domain\Contracts\NewsRepository;

class TestUpdates extends Command
{
    protected $signature = 'test:updates';
    protected $description = 'Test the new slug and excerpt features';

    public function handle(): int
    {
        // Teste de criação de categoria com slug
        $categoryInput = CreateCategoryInput::fromArray([
            'name' => 'Technology News',
            'slug' => null // vai gerar automaticamente
        ]);

        $repository = $this->laravel->make(CategoryRepository::class);
        $category = $repository->create($categoryInput);
        $this->info("✓ Category criada: ID {$category->id}, name: {$category->name}, slug: {$category->slug}");

        // Teste de criação de notícia com excerpt
        $newsInput = CreateNewsInput::fromArray([
            'title' => 'Breaking News About Tech',
            'content' => 'This is a very long content that should be truncated automatically when no excerpt is provided by the user because we have a great system.',
            'excerpt' => null, // vai gerar automaticamente
            'category_id' => $category->id
        ]);

        $newsRepository = $this->laravel->make(NewsRepository::class);
        $news = $newsRepository->create($newsInput);
        $this->info("✓ News criada: ID {$news->id}, title: {$news->title}");
        $this->info("  Excerpt (auto-generated): " . substr($news->excerpt ?? '', 0, 80));

        return 0;
    }
}

