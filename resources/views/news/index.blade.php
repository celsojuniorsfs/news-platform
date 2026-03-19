@extends('layouts.app', [
    'title' => 'Exibir Notícias | News Platform',
    'globalSearchValue' => $filters['title'] ?? '',
])

@section('content')
    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-neutral-500">Exibir notícias</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-neutral-950">Últimas notícias</h1>
                <p class="mt-2 max-w-2xl text-sm text-neutral-600">
                    Visualize as notícias cadastradas, filtre por título ou categoria e acesse os conteúdos em uma estrutura inspirada no wireframe.
                </p>
            </div>

            <a
                href="{{ route('categories.index') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
            >
                Ir para cadastro
            </a>
        </div>

        <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Filtros</h2>
                    <p class="text-sm text-neutral-500">Refine a listagem sem sair da página.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('news.index') }}" class="grid gap-4 lg:grid-cols-[1.5fr_1fr_auto]">
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-neutral-700">Título</label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ $filters['title'] ?? '' }}"
                        placeholder="Digite parte do título"
                        class="form-input"
                    >
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-neutral-700">Categoria</label>
                    <select id="category_id" name="category_id" class="form-input">
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
                        class="inline-flex h-12 w-full items-center justify-center rounded-2xl bg-neutral-900 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800 lg:w-auto"
                    >
                        Buscar
                    </button>

                    <a
                        href="{{ route('news.index') }}"
                        class="inline-flex h-12 w-full items-center justify-center rounded-2xl border border-neutral-300 bg-white px-5 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50 lg:w-auto"
                    >
                        Limpar
                    </a>
                </div>
            </form>
        </section>

        <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Cadastrar notícia</h2>
                    <p class="text-sm text-neutral-500">Formulário rápido para manter o fluxo funcional durante o teste.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('news.store') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="lg:col-span-2">
                        <label for="news-title" class="mb-2 block text-sm font-semibold text-neutral-700">Título</label>
                        <input
                            id="news-title"
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="Informe o título da notícia"
                            class="form-input"
                        >
                    </div>

                    <div>
                        <label for="news-category" class="mb-2 block text-sm font-semibold text-neutral-700">Categoria</label>
                        <select id="news-category" name="category_id" class="form-input">
                            <option value="">Selecione a categoria</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="news-excerpt" class="mb-2 block text-sm font-semibold text-neutral-700">Resumo</label>
                        <input
                            id="news-excerpt"
                            type="text"
                            name="excerpt"
                            value="{{ old('excerpt') }}"
                            placeholder="Resumo opcional para listagem"
                            class="form-input"
                        >
                    </div>

                    <div class="lg:col-span-2">
                        <label for="news-content" class="mb-2 block text-sm font-semibold text-neutral-700">Conteúdo</label>
                        <textarea
                            id="news-content"
                            name="content"
                            rows="6"
                            placeholder="Escreva o conteúdo da notícia"
                            class="form-textarea"
                        >{{ old('content') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
                    >
                        Salvar notícia
                    </button>
                </div>
            </form>
        </section>

        <section>
            <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Listagem</h2>
                    <p class="text-sm text-neutral-500">Cards responsivos com leitura simples e CTA de acesso.</p>
                </div>
            </div>

            @forelse ($newsItems as $news)
                @if ($loop->first)
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @endif

                <article class="flex min-h-[340px] flex-col rounded-[28px] border border-neutral-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-4 flex items-start justify-between gap-3">
                        <span class="inline-flex rounded-full bg-neutral-900 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                            {{ $news->category->name }}
                        </span>

                        @if ($news->created_at)
                            <span class="text-xs font-medium text-neutral-400">
                                {{ $news->created_at->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold leading-tight text-neutral-950">
                        {{ $news->title }}
                    </h3>

                    <p class="mt-4 flex-1 text-sm leading-6 text-neutral-600">
                        {{ $news->excerpt ?: \Illuminate\Support\Str::limit($news->content, 220) }}
                    </p>

                    <div class="mt-6">
                        <a
                            href="{{ route('news.show', $news->id) }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-neutral-200 px-4 py-3 text-sm font-semibold text-neutral-800 transition hover:bg-neutral-300"
                        >
                            Acessar
                        </a>
                    </div>
                </article>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="rounded-[28px] border border-dashed border-neutral-300 bg-white px-6 py-16 text-center shadow-sm">
                    <h3 class="text-lg font-bold text-neutral-900">Nenhuma notícia encontrada</h3>
                    <p class="mt-2 text-sm text-neutral-500">
                        Ajuste os filtros ou cadastre uma nova notícia para começar.
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
