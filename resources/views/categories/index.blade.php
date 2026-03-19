@extends('layouts.app', [
    'title' => 'Cadastrar Notícias | News Platform',
    'globalSearchValue' => request('title'),
])

@section('content')
    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-neutral-500">Cadastrar notícias</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-neutral-950">Categorias</h1>
                <p class="mt-2 max-w-2xl text-sm text-neutral-600">
                    Cadastre categorias para organizar as notícias e manter a base pronta para busca por categoria.
                </p>
            </div>

            <a
                href="{{ route('news.index') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
            >
                Ver notícias
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[420px_minmax(0,1fr)]">
            <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-neutral-950">Nova categoria</h2>
                    <p class="mt-1 text-sm text-neutral-500">Preencha os dados básicos para cadastro.</p>
                </div>

                <form method="POST" action="{{ route('categories.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-neutral-700">Nome</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex.: Tecnologia"
                            class="form-input"
                        >
                    </div>

                    <div>
                        <label for="slug" class="mb-2 block text-sm font-semibold text-neutral-700">Slug</label>
                        <input
                            id="slug"
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="Opcional"
                            class="form-input"
                        >
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
                        >
                            Salvar categoria
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-neutral-950">Categorias cadastradas</h2>
                    <p class="mt-1 text-sm text-neutral-500">Lista simples para apoio operacional.</p>
                </div>

                @forelse ($categories as $category)
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 px-4 py-4">
                        <div>
                            <p class="font-semibold text-neutral-900">{{ $category->name }}</p>
                            <p class="text-sm text-neutral-500">
                                {{ $category->slug ?: 'Slug não informado' }}
                            </p>
                        </div>

                        <span class="inline-flex rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-neutral-600">
                            Categoria
                        </span>
                    </div>

                    @if (! $loop->last)
                        <div class="h-3"></div>
                    @endif
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 px-6 py-12 text-center">
                        <h3 class="text-lg font-bold text-neutral-900">Nenhuma categoria cadastrada</h3>
                        <p class="mt-2 text-sm text-neutral-500">
                            Cadastre a primeira categoria para começar a organizar as notícias.
                        </p>
                    </div>
                @endforelse
            </section>
        </div>
    </section>
@endsection
