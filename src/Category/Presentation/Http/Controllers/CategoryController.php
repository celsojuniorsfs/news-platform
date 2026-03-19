<?php

declare(strict_types=1);

namespace Src\Category\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Application\UseCases\CreateCategoryUseCase;
use Src\Category\Application\UseCases\ListCategoriesUseCase;
use Src\Category\Domain\Exceptions\CategoryAlreadyExistsException;
use Src\Category\Presentation\Http\Requests\StoreCategoryRequest;

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
        try {
            $useCase->execute(
                CreateCategoryInput::fromArray($request->validated())
            );

            return redirect()
                ->back()
                ->with('success', 'Categoria cadastrada com sucesso.');
        } catch (CategoryAlreadyExistsException $exception) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'name' => $exception->getMessage(),
                ]);
        } catch (Throwable) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Não foi possível cadastrar a categoria. Tente novamente.',
                ]);
        }
    }
}
