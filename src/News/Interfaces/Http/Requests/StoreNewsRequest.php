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

    protected function prepareForValidation(): void
    {
        $title = $this->input('title');
        $content = $this->input('content');
        $excerpt = $this->input('excerpt');

        $this->merge([
            'title' => is_string($title) ? trim($title) : $title,
            'content' => is_string($content) ? trim($content) : $content,
            'excerpt' => is_string($excerpt) && trim($excerpt) !== '' ? trim($excerpt) : null,
        ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'excerpt' => ['nullable', 'string', 'max:500'],
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
            'excerpt' => 'resumo',
            'category_id' => 'categoria',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O título da notícia é obrigatório.',
            'content.required' => 'O conteúdo da notícia é obrigatório.',
            'category_id.required' => 'A categoria da notícia é obrigatória.',
            'category_id.exists' => 'A categoria informada não existe.',
        ];
    }
}
