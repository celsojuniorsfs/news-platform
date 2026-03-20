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
                    Cadastre categorias para organizar melhor as notícias.
                </p>
            </div>

            <a
                href="{{ route('news.create') }}"
                class="action-primary"
            >
                Voltar para cadastro de notícias
            </a>
        </div>

        <div class="grid gap-6 xl:grid-cols-[440px_minmax(0,1fr)]">
            <section class="page-section p-5 sm:p-6">
                <div class="mb-6">
                    <h2 class="section-title">Nova categoria</h2>
                    <p class="section-description mt-1">
                        Informe o nome da categoria.
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
                                Use um nome simples e fácil de identificar.
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
                            class="action-secondary"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="action-primary"
                        >
                            Salvar categoria
                        </button>
                    </div>
                </form>
            </section>

            <section class="page-section p-5 sm:p-6">
                <div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="section-title">Categorias cadastradas</h2>
                        <p class="section-description mt-1">
                            Veja as categorias disponíveis.
                        </p>
                    </div>

                    <span class="tag-badge w-fit">
                        {{ $categories->count() }} {{ $categories->count() === 1 ? 'registro' : 'registros' }}
                    </span>
                </div>

                @forelse ($categories as $category)
                    <article class="rounded-2xl border border-slate-200 bg-white px-4 py-4 shadow-[0_14px_34px_-26px_rgba(23,32,51,0.42)] transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_22px_42px_-28px_rgba(23,32,51,0.38)]">
                        <div class="flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="truncate text-base font-semibold text-neutral-900">
                                    {{ $category->name }}
                                </p>

                                <p class="mt-1 text-sm text-neutral-500">
                                    Pronta para uso
                                </p>
                            </div>

                            <span class="inline-flex shrink-0 rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-neutral-600">
                                Ativa
                            </span>
                        </div>
                    </article>

                    @if (! $loop->last)
                        <div class="h-3"></div>
                    @endif
                @empty
                    <div class="page-section border-dashed px-6 py-14 text-center">
                        <h3 class="text-lg font-bold text-neutral-900">Nenhuma categoria cadastrada</h3>
                        <p class="mt-2 text-sm text-neutral-500">
                            Cadastre a primeira categoria.
                        </p>
                    </div>
                @endforelse
            </section>
        </div>
    </section>
@endsection
