<?php

declare(strict_types=1);

namespace Src\News\Presentation\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Src\Category\Application\UseCases\ListCategoriesUseCase;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Application\DTOs\SearchNewsInput;
use Src\News\Application\UseCases\CreateNewsUseCase;
use Src\News\Application\UseCases\GetNewsDetailUseCase;
use Src\News\Application\UseCases\SearchNewsUseCase;
use Src\News\Domain\Exceptions\NewsNotFoundException;
use Src\News\Presentation\Http\Requests\StoreNewsRequest;

final class NewsController extends Controller
{
    public function index(
        Request $request,
        SearchNewsUseCase $searchNewsUseCase,
        ListCategoriesUseCase $listCategoriesUseCase,
    ): View {
        $filters = SearchNewsInput::fromArray($request->all());

        return view('news.index', [
            'newsItems' => $searchNewsUseCase->execute($filters),
            'categories' => $listCategoriesUseCase->execute(),
            'filters' => [
                'title' => $filters->title,
                'category_id' => $filters->categoryId,
            ],
        ]);
    }

    public function create(
        ListCategoriesUseCase $listCategoriesUseCase,
    ): View {
        return view('news.create', [
            'categories' => $listCategoriesUseCase->execute(),
        ]);
    }

    public function store(
        StoreNewsRequest $request,
        CreateNewsUseCase $useCase,
    ): RedirectResponse {
        try {
            $useCase->execute(
                CreateNewsInput::fromArray($request->validated())
            );

            return redirect()
                ->route('news.create')
                ->with('success', 'Notícia cadastrada com sucesso.');
        } catch (Throwable) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Não foi possível cadastrar a notícia. Tente novamente.',
                ]);
        }
    }

    public function show(
        int $news,
        GetNewsDetailUseCase $useCase,
    ): View {
        try {
            return view('news.show', [
                'newsItem' => $useCase->execute($news),
            ]);
        } catch (NewsNotFoundException) {
            throw new NotFoundHttpException('Notícia não encontrada.');
        }
    }
}
