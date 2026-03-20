<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'News Platform' }}</title>

    @php
        $hasViteAssets = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
    @endphp

    @if ($hasViteAssets)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-neutral-100 text-neutral-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-neutral-200 bg-neutral-200/95 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center justify-between gap-4">
                        <a
                            href="{{ route('news.index') }}"
                            class="inline-flex items-center gap-3 text-lg font-bold tracking-wide text-neutral-900 transition hover:text-neutral-700"
                        >
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-neutral-900 text-sm font-bold text-white shadow-sm">
                                NP
                            </span>
                            <span>NEWS PLATFORM</span>
                        </a>

                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-700 shadow-sm lg:hidden"
                            onclick="document.getElementById('mobile-nav').classList.toggle('hidden')"
                        >
                            Menu
                        </button>
                    </div>

                    <div class="hidden items-center gap-6 lg:flex">
                        <nav class="flex items-center gap-6 text-sm font-semibold uppercase tracking-wide text-neutral-700">
                            <a
                                href="{{ route('news.create') }}"
                                class="{{ request()->routeIs('news.create') ? 'text-neutral-950' : 'text-neutral-600' }} transition hover:text-neutral-950"
                            >
                                Cadastrar Notícias
                            </a>

                            <a
                                href="{{ route('news.index') }}"
                                class="{{ request()->routeIs('news.index') || request()->routeIs('news.show') ? 'text-neutral-950' : 'text-neutral-600' }} transition hover:text-neutral-950"
                            >
                                Exibir Notícias
                            </a>
                        </nav>

                        <form method="GET" action="{{ route('news.index') }}" class="w-full max-w-sm">
                            <label for="global-search" class="sr-only">Buscar notícias</label>

                            <div class="relative">
                                <input
                                    id="global-search"
                                    type="text"
                                    name="title"
                                    value="{{ $globalSearchValue ?? request('title') }}"
                                    placeholder="Buscar por título"
                                    class="h-11 w-full rounded-full border border-neutral-300 bg-white pl-4 pr-12 text-sm text-neutral-800 shadow-sm outline-none transition placeholder:text-neutral-400 focus:border-neutral-500 focus:ring-2 focus:ring-neutral-300"
                                >

                                <button
                                    type="submit"
                                    class="absolute inset-y-0 right-1 my-1 inline-flex w-10 items-center justify-center rounded-full bg-neutral-900 text-white transition hover:bg-neutral-800"
                                    aria-label="Buscar"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="mobile-nav" class="hidden space-y-4 lg:hidden">
                    <nav class="grid gap-2 rounded-2xl border border-neutral-300 bg-white p-3 shadow-sm">
                        <a
                            href="{{ route('news.create') }}"
                            class="rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-100 hover:text-neutral-950"
                        >
                            Cadastrar Notícias
                        </a>

                        <a
                            href="{{ route('news.index') }}"
                            class="rounded-xl px-3 py-2 text-sm font-semibold text-neutral-700 transition hover:bg-neutral-100 hover:text-neutral-950"
                        >
                            Exibir Notícias
                        </a>
                    </nav>

                    <form method="GET" action="{{ route('news.index') }}">
                        <label for="mobile-global-search" class="sr-only">Buscar notícias</label>

                        <div class="relative">
                            <input
                                id="mobile-global-search"
                                type="text"
                                name="title"
                                value="{{ $globalSearchValue ?? request('title') }}"
                                placeholder="Buscar por título"
                                class="h-11 w-full rounded-full border border-neutral-300 bg-white pl-4 pr-12 text-sm text-neutral-800 shadow-sm outline-none transition placeholder:text-neutral-400 focus:border-neutral-500 focus:ring-2 focus:ring-neutral-300"
                            >

                            <button
                                type="submit"
                                class="absolute inset-y-0 right-1 my-1 inline-flex w-10 items-center justify-center rounded-full bg-neutral-900 text-white transition hover:bg-neutral-800"
                                aria-label="Buscar"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1">
            <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('general'))
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 shadow-sm">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                @if ($errors->any() && !View::hasSection('suppressGlobalErrors'))
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 shadow-sm">
                        <p class="mb-2 text-sm font-semibold text-red-700">Verifique os campos destacados no formulario.</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="border-t border-neutral-200 bg-neutral-300">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-center px-4 py-4 text-center text-sm font-semibold uppercase tracking-wide text-neutral-700 sm:px-6 lg:px-8">
                Desenvolvido por Programador
            </div>
        </footer>
    </div>
</body>
</html>
