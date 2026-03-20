@extends('layouts.app', [
    'title' => 'Cadastrar Categorias | News Platform',
    'globalSearchValue' => request('title'),
])

@section('suppressGlobalErrors', 'true')

@section('content')
    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-neutral-500">Cadastro</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-neutral-950">Cadastrar categorias</h1>
                <p class="mt-2 max-w-2xl text-sm text-neutral-600">
                    Cadastre categorias para organizar melhor as notícias e permitir filtros mais eficientes na listagem.
                </p>
            </div>

            <a
                href="{{ route('news.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
            >
                Voltar para cadastro de notícias
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-[440px_minmax(0,1fr)]">
            <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-neutral-950">Nova categoria</h2>
                    <p class="mt-1 text-sm text-neutral-500">
                        Preencha o nome da categoria.
                    </p>
                </div>

                <form method="POST" action="{{ route('categories.store') }}" class="space-y-5" novalidate>
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-neutral-700">
                            Nome da categoria <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Ex.: Tecnologia"
                            maxlength="255"
                            class="form-input @error('name') form-input-error @enderror"
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            aria-describedby="{{ $errors->has('name') ? 'name-error' : 'name-help' }}"
                        >

                        @error('name')
                            <p id="name-error" class="mt-2 text-sm font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @else
                            <p id="name-help" class="mt-2 text-sm text-neutral-500">
                                Informe um nome claro e objetivo para facilitar a organização das notícias.
                            </p>
                        @enderror
                    </div>

                    <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                        <h3 class="text-sm font-semibold text-neutral-800">Boas práticas</h3>
                        <ul class="mt-2 space-y-1 text-sm text-neutral-600">
                            <li>• Evite nomes duplicados.</li>
                            <li>• Prefira nomes curtos e consistentes.</li>
                            <li>• Use categorias amplas, como Política, Esportes ou Tecnologia.</li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('news.create') }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-neutral-300 bg-white px-5 py-3 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
                        >
                            Salvar categoria
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-neutral-950">Categorias cadastradas</h2>
                        <p class="mt-1 text-sm text-neutral-500">
                            Visualize as categorias já disponíveis para uso no cadastro de notícias.
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full bg-neutral-900 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                        {{ $categories->count() }} {{ $categories->count() === 1 ? 'registro' : 'registros' }}
                    </span>
                </div>

                @forelse ($categories as $category)
                    <article class="flex items-center justify-between gap-4 rounded-2xl border border-neutral-200 bg-white px-4 py-4 transition hover:border-neutral-300 hover:shadow-sm">
                        <div class="min-w-0">
                            <p class="truncate text-base font-semibold text-neutral-900">
                                {{ $category->name }}
                            </p>

                            <p class="mt-1 text-sm text-neutral-500">
                                Categoria disponível para associação com notícias
                            </p>
                        </div>

                        <span class="inline-flex shrink-0 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-neutral-600">
                            Ativa
                        </span>
                    </article>

                    @if (! $loop->last)
                        <div class="h-3"></div>
                    @endif
                @empty
                    <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-6 py-14 text-center">
                        <h3 class="text-lg font-bold text-neutral-900">Nenhuma categoria cadastrada</h3>
                        <p class="mt-2 text-sm text-neutral-500">
                            Cadastre a primeira categoria utilizando o formulário ao lado.
                        </p>
                    </div>
                @endforelse
            </section>
        </div>
    </section>
@endsection
