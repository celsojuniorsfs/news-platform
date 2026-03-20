@extends('layouts.app', [
    'title' => 'Cadastrar Notícias | News Platform',
    'globalSearchValue' => request('title'),
])

@section('suppressGlobalErrors', 'true')

@section('content')
    @php
        $hasCategories = $categories->isNotEmpty();
    @endphp

    <section class="space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-neutral-500">Cadastro</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-neutral-950">Cadastrar notícias</h1>
                <p class="mt-2 max-w-2xl text-sm text-neutral-600">
                    Preencha os dados da notícia em uma tela dedicada, com validação visual e acesso rápido ao cadastro de categorias.
                </p>
            </div>

            <a
                href="{{ route('news.index') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800"
            >
                Exibir notícias
            </a>
        </div>

        <section class="mx-auto w-full max-w-3xl rounded-[28px] border border-neutral-200 bg-white p-5 shadow-sm sm:p-8">
            <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-neutral-950">Formulário da notícia</h2>
                    <p class="mt-1 text-sm text-neutral-500">
                        Título, conteúdo e categoria obrigatórios para um cadastro consistente.
                    </p>
                </div>

                <a
                    href="{{ route('categories.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-neutral-300 bg-white px-4 py-3 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50"
                >
                    Cadastrar categorias
                </a>
            </div>

            <form method="POST" action="{{ route('news.store') }}" class="space-y-5" novalidate>
                @csrf

                <div>
                    <label for="news-title" class="mb-2 block text-sm font-semibold text-neutral-700">
                        Título da notícia <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="news-title"
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Digite o título da notícia"
                        maxlength="255"
                        class="form-input @error('title') form-input-error @enderror"
                        aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('title') ? 'title-error' : 'title-help' }}"
                    >

                    @error('title')
                        <p id="title-error" class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p id="title-help" class="mt-2 text-sm text-neutral-500">
                            Use um título objetivo para facilitar a identificação da notícia na listagem.
                        </p>
                    @enderror
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="news-category" class="block text-sm font-semibold text-neutral-700">
                            Categoria <span class="text-red-500">*</span>
                        </label>

                        <a
                            href="{{ route('categories.index') }}"
                            class="text-sm font-semibold text-neutral-700 underline decoration-neutral-300 underline-offset-4 transition hover:text-neutral-950"
                        >
                            Nova categoria
                        </a>
                    </div>

                    <select
                        id="news-category"
                        name="category_id"
                        class="form-input @error('category_id') form-input-error @enderror"
                        aria-invalid="{{ $errors->has('category_id') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('category_id') ? 'category-error' : 'category-help' }}"
                        @disabled(! $hasCategories)
                    >
                        <option value="">{{ $hasCategories ? 'Selecione uma categoria' : 'Cadastre uma categoria antes' }}</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected((string) old('category_id') === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p id="category-error" class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p id="category-help" class="mt-2 text-sm text-neutral-500">
                            {{ $hasCategories ? 'Escolha a categoria que melhor representa a notícia.' : 'Você ainda não tem categorias disponíveis para vincular.' }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="news-content" class="mb-2 block text-sm font-semibold text-neutral-700">
                        Conteúdo / descrição <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="news-content"
                        name="content"
                        rows="10"
                        placeholder="Digite o conteúdo ou descrição da notícia"
                        class="form-textarea min-h-[220px] @error('content') form-input-error @enderror"
                        aria-invalid="{{ $errors->has('content') ? 'true' : 'false' }}"
                        aria-describedby="{{ $errors->has('content') ? 'content-error' : 'content-help' }}"
                    >{{ old('content') }}</textarea>

                    @error('content')
                        <p id="content-error" class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @else
                        <p id="content-help" class="mt-2 text-sm text-neutral-500">
                            Informe um conteúdo claro e completo para apoiar a exibição e a futura tela de detalhe.
                        </p>
                    @enderror
                </div>

                <div class="rounded-2xl border border-neutral-200 bg-neutral-50 px-4 py-4">
                    <h3 class="text-sm font-semibold text-neutral-800">Boas práticas</h3>
                    <ul class="mt-2 space-y-1 text-sm text-neutral-600">
                        <li>• Evite títulos genéricos.</li>
                        <li>• Relacione a notícia à categoria correta.</li>
                        <li>• Prefira descrições completas e de leitura fácil.</li>
                    </ul>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('news.create') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-neutral-300 bg-white px-5 py-3 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-50"
                    >
                        Limpar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-neutral-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-neutral-800 disabled:cursor-not-allowed disabled:opacity-60"
                        @disabled(! $hasCategories)
                    >
                        Salvar notícia
                    </button>
                </div>
            </form>
        </section>
    </section>
@endsection
