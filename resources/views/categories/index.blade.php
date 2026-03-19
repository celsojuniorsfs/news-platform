<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Categorias</title>
</head>
<body>
    <h1>Categorias</h1>

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

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nome da categoria" value="{{ old('name') }}">
        <br><br>

        <input type="text" name="slug" placeholder="Slug opcional" value="{{ old('slug') }}">
        <br><br>

        <button type="submit">Salvar</button>
    </form>

    <ul>
        @foreach ($categories as $category)
            <li>
                {{ $category->name }}
                @if ($category->slug)
                    - <small>{{ $category->slug }}</small>
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>

