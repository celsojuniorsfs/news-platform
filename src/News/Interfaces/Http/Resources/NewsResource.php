<?php

declare(strict_types=1);

namespace Src\News\Interfaces\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Src\News\Infrastructure\Models\News
 */
final class NewsResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'title' => (string) $this->title,
            'content' => (string) $this->content,
            'excerpt' => $this->excerpt !== null ? (string) $this->excerpt : null,
            'category' => [
                'id' => (int) $this->category->id,
                'name' => (string) $this->category->name,
                'slug' => $this->category->slug !== null ? (string) $this->category->slug : null,
            ],
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}

