<?php

declare(strict_types=1);

namespace Src\Category\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $name = $this->input('name');
        $slug = $this->input('slug');

        $this->merge([
            'name' => is_string($name) ? trim($name) : $name,
            'slug' => is_string($slug) && trim($slug) !== ''
                ? Str::slug(trim($slug))
                : null,
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:categories,name'],
            'slug' => [
                'nullable',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('categories', 'slug'),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'slug' => 'slug',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.unique' => 'Já existe uma categoria com esse nome.',
            'slug.unique' => 'Já existe uma categoria com esse slug.',
            'slug.regex' => 'O campo slug deve conter apenas letras minúsculas, números e hífens.',
        ];
    }
}
