# 📰 Plataforma de Notícias

Plataforma simples para cadastrar e consultar notícias, desenvolvida com **Laravel 12**.

---

### Pré-requisitos

Você precisa ter instalado:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

### Instalação rápida

```bash
# 1️⃣ Clone o repositório
git clone https://github.com/celsojuniorsfs/news-platform.git
cd news-platform

# 2️⃣ Suba o projeto
./vendor/bin/sail up -d

# 3️⃣ Configure a aplicação
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate

# 4️⃣ Pronto! Acesse http://localhost
```

---

## 📚 Stack tecnológico

- **PHP 8.2** + **Laravel 12**
- **MySQL** (banco de dados)
- **Docker** (ambiente completo)
- **Blade** (templates)
