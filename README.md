# 📰 Plataforma de Notícias

Plataforma simples para cadastrar e consultar notícias, desenvolvida com **Laravel 12**.

---

## 🚀 Quick Start (Docker)

### Pré-requisitos

- Docker Desktop
- Git
- Bash

### Instalação em 6 passos

# 1️⃣ Clone o repositório
git clone https://github.com/celsojuniorsfs/news-platform.git
cd news-platform

# 2️⃣ Crie o arquivo de ambiente
cp .env.example .env

# 3️⃣ Suba os containers
docker-compose up -d --build

# 4️⃣ Gere a chave da aplicação
docker-compose exec app php artisan key:generate

# 5️⃣ Rode as migrations
docker-compose exec app php artisan migrate

# 6️⃣ Rode os seeders
docker-compose exec app php artisan db:seed

# Acesse
# 🌐 http://localhost:8080
