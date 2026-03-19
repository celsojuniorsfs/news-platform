<?php

declare(strict_types=1);

namespace Src\News\Interfaces\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Category\Application\UseCases\ListCategoriesUseCase;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Application\UseCases\CreateNewsUseCase;
use Src\News\Application\UseCases\SearchNewsUseCase;
use Src\News\Interfaces\Http\Requests\StoreNewsRequest;

final class NewsController extends Controller
{
    public function index(
        Request $request,
        SearchNewsUseCase $searchNewsUseCase,
        ListCategoriesUseCase $listCategoriesUseCase,
    ): View {
        $title = $request->string('title')->toString() ?: null;
        $categoryId = $request->integer('category_id') ?: null;

        return view('news.index', [
            'newsItems' => $searchNewsUseCase->execute($title, $categoryId),
            'categories' => $listCategoriesUseCase->execute(),
            'filters' => [
                'title' => $title,
                'category_id' => $categoryId,
            ],
        ]);
    }

    public function store(
        StoreNewsRequest $request,
        CreateNewsUseCase $useCase,
    ): RedirectResponse {
        $useCase->execute(
            CreateNewsInput::fromArray($request->validated())
        );

        return redirect()
            ->route('news.index')
            ->with('success', 'Notícia cadastrada com sucesso.');
    }
}

