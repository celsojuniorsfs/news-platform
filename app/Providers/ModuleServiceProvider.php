<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\Category\Infrastructure\Persistence\EloquentCategoryRepository;
use Src\News\Domain\Contracts\NewsRepository;
use Src\News\Infrastructure\Persistence\EloquentNewsRepository;

final class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(NewsRepository::class, EloquentNewsRepository::class);
    }

    public function boot(): void
    {
    }
}

