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
            'category' => [
                'id' => (int) $this->category->id,
                'name' => (string) $this->category->name,
            ],
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

