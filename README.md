# Plataforma de Noticias

Aplicacao simples para cadastro, listagem e consulta de noticias, desenvolvida com Laravel 12 e organizada como monolito modular.

## Objetivo

Este projeto foi estruturado para permitir avaliacao rapida do backend e da interface web sem setup manual fora do Docker.

## Pre-requisitos

- Docker Desktop
- Docker Compose
- Git

Opcional:

- Navegador para acessar a interface em `http://localhost:8080`
- Cliente MySQL para inspecionar o banco local em `localhost:3306`

## Stack

- PHP 8.3
- Laravel 12
- MySQL 8
- Nginx
- Pest
- PHPUnit 12

## Passo a passo com Docker

### 1. Clonar o repositorio

```bash
git clone https://github.com/celsojuniorsfs/news-platform.git
cd news-platform
```

### 2. Criar o arquivo de ambiente

```bash
cp .env.example .env
```

Se estiver no PowerShell e nao tiver `cp` configurado:

```powershell
Copy-Item .env.example .env
```

### 3. Subir os containers

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml up -d --build
```

Esse comando monta o codigo do projeto dentro do container e deve ser usado para executar comandos do Artisan, como `key:generate` e `migrate`.

### 4. Gerar a chave da aplicacao

```bash
docker compose exec app php artisan key:generate
```

### 5. Rodar as migrations

```bash
docker compose exec app php artisan migrate
```

### 6. Instalar as dependencias do frontend

Execute no host, na raiz do projeto:

```bash
npm install
```

### 7. Subir o Vite em modo de desenvolvimento

Execute no host, na raiz do projeto:

```bash
npm run dev
```

Com o Vite em execucao, o layout e os assets do frontend serao carregados corretamente durante os testes no navegador.

## Como subir a aplicacao

Depois de subir os containers, a aplicacao fica disponivel em:

- URL local: `http://localhost:8080`

Containers principais:

- `news-platform-app`: PHP-FPM + Laravel
- `news-platform-nginx`: servidor web exposto na porta `8080`
- `news-platform-db`: MySQL 8 exposto na porta `3306`

Para acompanhar o status:

```bash
docker compose ps
```

Para parar a stack:

```bash
docker compose down
```

Para derrubar tudo incluindo volumes:

```bash
docker compose down -v
```

## Como rodar migrations e seeders

### Rodar migrations

```bash
docker compose exec app php artisan migrate
```

### Rodar seeders

```bash
docker compose exec app php artisan db:seed
```

### Rodar migrations do zero com seed

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### Seeders disponiveis

- `DatabaseSeeder`: orquestra o carregamento principal
- `CategorySeeder`: categorias padrao
- `NewsSeeder`: noticias fixas + massa adicional via factory

## Como rodar testes

A suite automatizada usa:

- Pest
- PHPUnit 12
- `RefreshDatabase`
- Factories
- Seeders
- MySQL dedicado para testes quando aplicavel

O arquivo [phpunit.xml](/abs/path/c:/Users/celso/PhpstormProjects/news-platform/phpunit.xml#L1) define `DB_DATABASE=testing`, entao a base `testing` precisa existir no MySQL do container.

### 1. Criar o banco de teste

```bash
docker compose exec db mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; GRANT ALL PRIVILEGES ON testing.* TO 'laravel'@'%'; FLUSH PRIVILEGES;"
```

### 2. Rodar toda a suite

```bash
docker compose exec app composer test
```

### 3. Rodar apenas os testes feature do desafio

```bash
docker compose exec app ./vendor/bin/pest tests/Feature/Category/CategoryControllerTest.php tests/Feature/News/NewsControllerTest.php
```

## Decisoes arquiteturais

O projeto segue a diretriz de monolito modular documentada em [docs/architecture/modular-monolith.md](/abs/path/c:/Users/celso/PhpstormProjects/news-platform/docs/architecture/modular-monolith.md#L1).

Principais decisoes:

- Separacao por modulo de negocio em `src/Category` e `src/News`
- Casos de uso explicitos na camada `Application`
- Regras e contratos concentrados em `Domain`
- Controllers, Requests e Resources em `Presentation`
- Eloquent Models e repositorios concretos em `Infrastructure`
- Inversao de dependencia via bind de interfaces no [ModuleServiceProvider](/abs/path/c:/Users/celso/PhpstormProjects/news-platform/app/Providers/ModuleServiceProvider.php#L1)

Fluxo resumido do backend:

1. A rota chama um controller HTTP.
2. O controller delega a um use case.
3. O use case conversa com um contrato de repositorio.
4. A implementacao concreta persiste e consulta via Eloquent.

## Estrutura de pastas

```txt
app/
├─ Providers/

bootstrap/

config/

database/
├─ factories/
├─ migrations/
└─ seeders/

docker/
├─ nginx/
└─ php/

resources/
├─ css/
├─ js/
└─ views/

routes/
└─ web.php

src/
├─ Category/
│  ├─ Application/
│  ├─ Domain/
│  ├─ Infrastructure/
│  └─ Presentation/
└─ News/
   ├─ Application/
   ├─ Domain/
   ├─ Infrastructure/
   └─ Presentation/

tests/
├─ Feature/
├─ Unit/
└─ Pest.php
```

## URL local e telas principais

URL base:

- `http://localhost:8080`

Telas e endpoints web principais:

- `GET /` redireciona para listagem de noticias
- `GET /news` lista noticias e permite busca por titulo e categoria
- `GET /news/create` exibe o formulario de cadastro de noticia
- `POST /news` cadastra uma noticia
- `GET /news/{news}` exibe o detalhe de uma noticia
- `GET /categories` lista categorias
- `POST /categories` cadastra uma categoria

## Dados de ambiente local

Configuracao padrao do banco no ambiente Docker:

- host: `db`
- porta interna: `3306`
- banco principal: `news_platform`
- banco de testes: `testing`
- usuario: `laravel`
- senha: `secret`

Exposicao local do MySQL:

- host externo: `localhost`
- porta externa: `3306`

## Observacoes para avaliacao

- O fluxo principal da aplicacao pode ser validado inteiramente pelo navegador via `http://localhost:8080`
- O backend possui cobertura automatizada para categorias e noticias
- O comando recomendado para verificacao rapida e `docker compose exec app composer test`
