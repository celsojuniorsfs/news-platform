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
                class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
            >
                Cadastrar notícia
            </a>
        </div>

        <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Filtros</h2>
                    <p class="text-sm text-neutral-500">Busque pelo título da notícia.</p>
                </div>
            </div>

            <form method="GET" action="{{ route('news.index') }}" class="grid gap-4 lg:grid-cols-[1.4fr_auto]">
                <div>
                    <label for="filter-title" class="mb-2 block text-sm font-semibold text-neutral-700">Título</label>
                    <input
                        id="filter-title"
                        type="text"
                        name="title"
                        value="{{ $filters['title'] ?? '' }}"
                        placeholder="Digite parte do título"
                        class="form-input"
                    >
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

        <section>
            <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Listagem</h2>
                    <p class="text-sm text-neutral-500">Confira as notícias já publicadas.</p>
                </div>

                <span class="inline-flex w-fit rounded-full bg-neutral-900 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                    {{ $newsItems->total() }} {{ $newsItems->total() === 1 ? 'registro' : 'registros' }}
                </span>
            </div>

            @forelse ($newsItems as $news)
                @if ($loop->first)
                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @endif

                <article class="flex min-h-[360px] flex-col rounded-[10px] border border-neutral-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-neutral-950">
                            {{ $news->title }}
                        </h3>
                    </div>

                    <p class="text-sm leading-6 text-neutral-700">
                        {{ \Illuminate\Support\Str::limit($news->content, 280) }}
                    </p>

                    <div class="mt-4 text-xs font-medium uppercase tracking-wide text-neutral-400">
                        {{ $news->category->name }}
                    </div>

                    <div class="mt-auto pt-6">
                        <a
                            href="{{ route('news.show', $news->id) }}"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-neutral-200 px-4 py-3 text-sm font-semibold text-neutral-800 transition hover:bg-neutral-300"
                        >
                            Acessar
                        </a>
                    </div>
                </article>

                @if ($loop->last)
                    </div>
                @endif
            @empty
                <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-6 py-14 text-center">
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
