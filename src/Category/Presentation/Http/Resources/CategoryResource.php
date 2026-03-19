<?php

declare(strict_types=1);

namespace Src\Category\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Src\Category\Infrastructure\Models\Category
 */
final class CategoryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'slug' => $this->slug !== null ? (string) $this->slug : null,
        ];
    }
}
