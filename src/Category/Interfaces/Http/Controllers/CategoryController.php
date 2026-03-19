<?php

declare(strict_types=1);

namespace Src\Category\Interfaces\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Application\UseCases\CreateCategoryUseCase;
use Src\Category\Application\UseCases\ListCategoriesUseCase;
use Src\Category\Interfaces\Http\Requests\StoreCategoryRequest;

final class CategoryController extends Controller
{
    public function index(ListCategoriesUseCase $useCase): View
    {
        return view('categories.index', [
            'categories' => $useCase->execute(),
        ]);
    }

    public function store(
        StoreCategoryRequest $request,
        CreateCategoryUseCase $useCase,
    ): RedirectResponse {
        $useCase->execute(
            CreateCategoryInput::fromArray($request->validated())
        );

        return redirect()
            ->back()
            ->with('success', 'Categoria cadastrada com sucesso.');
    }
}

