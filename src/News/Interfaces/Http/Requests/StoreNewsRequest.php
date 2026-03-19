<?php

declare(strict_types=1);

namespace Src\News\Interfaces\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'título',
            'content' => 'conteúdo',
            'category_id' => 'categoria',
        ];
    }
}

