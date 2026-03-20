@extends('layouts.app', [
    'title' => 'Exibir Notícias | News Platform',
    'globalSearchValue' => $filters['title'] ?? '',
])

@section('content')
    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-neutral-500">Notícias</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-neutral-950">Exibir notícias</h1>
                <p class="mt-2 max-w-2xl text-sm text-neutral-600">
                    Veja as notícias cadastradas e encontre o que precisa mais rápido.
                </p>
            </div>

            <a
                href="{{ route('news.create') }}"
                class="action-primary"
            >
                Cadastrar notícia
            </a>
        </div>

        <section class="page-section p-5 sm:p-6">
            <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-title">Filtros</h2>
                    <p class="section-description">Busque pelo título da notícia.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('news.index') }}" class="grid gap-4 lg:grid-cols-[1.3fr_1fr_auto]">
                <div>
                    <label for="filter-title" class="mb-2 block text-sm font-semibold text-neutral-700">Título</label>
                    <input
                        id="filter-title"
                        type="text"
                        name="title"
                        value="{{ $filters['title'] ?? '' }}"
                        placeholder="Digite parte do titulo"
                        class="form-input"
                    >
                </div>

                <div>
                    <label for="filter-category" class="mb-2 block text-sm font-semibold text-neutral-700">Categoria</label>
                    <select id="filter-category" name="category_id" class="form-input">
                        <option value="">Todas as categorias</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected((string) $category->id === (string) ($filters['category_id'] ?? ''))
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button
                        type="submit"
                        class="action-primary h-12 w-full lg:w-auto"
                    >
                        Buscar
                    </button>

                    <a
                        href="{{ route('news.index') }}"
                        class="action-secondary h-12 w-full lg:w-auto"
                    >
                        Limpar
                    </a>
                </div>
            </form>
        </section>

        <section>
            <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-title">Listagem</h2>
                    <p class="section-description">Confira as notícias já publicadas.</p>
                </div>

                <span class="tag-badge w-fit">
                    {{ $newsItems->total() }} {{ $newsItems->total() === 1 ? 'registro' : 'registros' }}
                </span>
            </div>

            @forelse ($newsItems as $news)
                @if ($loop->first)
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @endif

                <article class="news-card">
                    <div class="mb-4">
                        <h3 class="text-xl font-bold leading-tight text-neutral-950">
                            {{ $news->title }}
                        </h3>
                    </div>

                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-neutral-400">
                        Resumo
                    </p>

                    <p class="text-sm leading-6 text-neutral-700">
                        {{ $news->excerpt ?: \Illuminate\Support\Str::limit($news->content, 220) }}
                    </p>

                    <div class="mt-4">
                        <span class="tag-badge">
                            {{ $news->category->name }}
                        </span>
                    </div>

                    <div class="mt-auto pt-6">
                        <a
                            href="{{ route('news.show', $news->id) }}"
                            class="action-secondary w-full"
                        >
                            Acessar
                        </a>
                    </div>
                </article>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="page-section border-dashed px-6 py-14 text-center">
                    <h3 class="text-lg font-bold text-neutral-900">Nenhuma notícia encontrada</h3>
                    <p class="mt-2 text-sm text-neutral-500">
                        Tente outra busca ou cadastre uma nova notícia.
                    </p>
                </div>
            @endforelse

            @if ($newsItems->count() > 0)
                <div class="mt-8">
                    {{ $newsItems->links() }}
                </div>
            @endif
        </section>
    </section>
@endsection
