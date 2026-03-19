# 📰 Plataforma de Notícias

Plataforma simples para cadastrar e consultar notícias, desenvolvida com **Laravel 12**.

---

## 🚀 Quick Start (Docker)

### Pré-requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git
- Bash

### Instalação em 3 Passos

```bash
# 1️⃣ Clone o repositório
git clone https://github.com/celsojuniorsfs/news-platform.git
cd news-platform

# 2️⃣ Configure e suba o ambiente
cp .env.example .env
docker-compose up -d

# 3️⃣ Rode as migrations
docker-compose exec app php artisan migrate

# 4️⃣ Acesse a aplicação
# 🌐 http://localhost:8080
```

✅ Pronto! A aplicação está rodando em `http://localhost:8080`

---

## 📚 Stack Tecnológico

- **PHP 8.3** + **Laravel 12**
- **MySQL 8.0** (banco de dados)
- **Nginx** (servidor web)
- **Docker** + **Docker Compose** (ambiente)
- **Tailwind CSS** (estilização)
- **Vite** (bundler de assets)
