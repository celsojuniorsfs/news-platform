@extends('layouts.app', [
    'title' => $newsItem->title . ' | News Platform',
    'globalSearchValue' => request('title'),
])

@section('content')
    <section class="space-y-8">
        <div class="flex justify-end">
            <a
                href="{{ route('news.index') }}"
                class="action-secondary"
            >
                Voltar para notícias
            </a>
        </div>

        <article class="mx-auto w-full max-w-4xl">
            <header class="border-b border-neutral-200 pb-6">
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <span class="tag-badge">
                        {{ $newsItem->category->name }}
                    </span>

                    @if ($newsItem->created_at)
                        <span class="text-sm font-medium text-neutral-400">
                            {{ $newsItem->created_at->format('d/m/Y H:i') }}
                        </span>
                    @endif
                </div>

                <h2 class="max-w-3xl text-3xl font-bold leading-tight tracking-tight text-neutral-950 sm:text-5xl">
                    {{ $newsItem->title }}
                </h2>
            </header>

            <div class="pt-10">
                <div class="prose prose-lg prose-neutral max-w-none text-neutral-700">
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
