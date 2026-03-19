<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\News\Infrastructure\Models\News;

final class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return HasMany<News, self>
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'category_id');
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
