<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Notícias</title>
</head>
<body>
    <h1>Notícias</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->has('general'))
        <p>{{ $errors->first('general') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Buscar notícias</h2>

    <form method="GET" action="{{ route('news.index') }}">
        <input
            type="text"
            name="title"
            placeholder="Buscar por título"
            value="{{ $filters['title'] ?? '' }}"
        >

        <select name="category_id">
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

        <button type="submit">Buscar</button>
    </form>

    <hr>

    <h2>Nova notícia</h2>

    <form method="POST" action="{{ route('news.store') }}">
        @csrf

        <input type="text" name="title" placeholder="Título" value="{{ old('title') }}">
        <br><br>

        <textarea name="content" placeholder="Conteúdo">{{ old('content') }}</textarea>
        <br><br>

        <textarea name="excerpt" placeholder="Resumo opcional para listagem">{{ old('excerpt') }}</textarea>
        <br><br>

        <select name="category_id">
            <option value="">Selecione a categoria</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <br><br>
        <button type="submit">Salvar</button>
    </form>

    <hr>

    <h2>Lista de notícias</h2>

    @forelse ($newsItems as $news)
        <article style="margin-bottom: 24px;">
            <h3>{{ $news->title }}</h3>

            <p>
                <strong>Categoria:</strong> {{ $news->category->name }}
            </p>

            <p>
                {{ $news->excerpt ?: \Illuminate\Support\Str::limit($news->content, 180) }}
            </p>

            <a href="{{ route('news.show', $news->id) }}">Acessar</a>
        </article>
    @empty
        <p>Nenhuma notícia encontrada para os filtros informados.</p>
    @endforelse

    {{ $newsItems->links() }}
</body>
</html>

