@extends('layouts.app', [
    'title' => $newsItem->title . ' | News Platform',
    'globalSearchValue' => request('title'),
])

@section('content')
    <section class="space-y-8">
        <div class="flex justify-end">
            <a
                href="{{ route('news.index') }}"
                class="inline-flex items-center justify-center rounded-2xl border border-neutral-300 bg-white px-5 py-3 text-sm font-semibold text-neutral-700 shadow-sm transition hover:bg-neutral-50"
            >
                Voltar para notícias
            </a>
        </div>

        <article class="mx-auto w-full max-w-4xl">
            <header class="border-b border-neutral-200 pb-6">
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <span class="inline-flex rounded-full bg-neutral-900 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">
                        {{ $newsItem->category->name }}
                    </span>

                    @if ($newsItem->created_at)
                        <span class="text-sm text-neutral-400">
                            {{ $newsItem->created_at->format('d/m/Y H:i') }}
                        </span>
                    @endif
                </div>

                <h2 class="text-3xl font-bold leading-tight text-neutral-950 sm:text-4xl">
                    {{ $newsItem->title }}
                </h2>
            </header>

            <div class="pt-8">
                <div class="prose prose-neutral max-w-none text-base leading-8 text-neutral-700">
                    @foreach (preg_split("/(\r\n|\n|\r){2,}/", trim($newsItem->content)) as $paragraph)
                        @if (trim($paragraph) !== '')
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </article>
    </section>
@endsection
