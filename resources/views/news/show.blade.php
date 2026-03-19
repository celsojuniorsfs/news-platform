<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $newsItem->title }}</title>
</head>
<body>
    <p>
        <a href="{{ route('news.index') }}">Voltar para listagem</a>
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <article>
        <h1>{{ $newsItem->title }}</h1>

        <p>
            <strong>Categoria:</strong> {{ $newsItem->category->name }}
        </p>

        @if ($newsItem->excerpt)
            <p>
                <strong>Resumo:</strong> {{ $newsItem->excerpt }}
            </p>
        @endif

        <div>
            <p>{{ $newsItem->content }}</p>
        </div>

        <p>
            <small>Criada em: {{ $newsItem->created_at?->format('d/m/Y H:i') }}</small>
        </p>
    </article>
</body>
</html>
