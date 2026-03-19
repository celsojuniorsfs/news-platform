# 📦 Configuração Docker - News Platform

Este documento descreve como configurar e executar o projeto **News Platform** usando Docker e docker-compose.

## 🎯 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **Docker Desktop** ([download](https://www.docker.com/products/docker-desktop/))
- **Git** ([download](https://git-scm.com))
- **Bash** (incluído por padrão em macOS e Linux, Windows 11 com WSL2)

## 🚀 Iniciando o Ambiente

### Passo 1: Clonar o Repositório

```bash
git clone https://github.com/celsojuniorsfs/news-platform.git
cd news-platform
```

### Passo 2: Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

O arquivo `.env` já contém as configurações necessárias para o Docker. As principais variáveis são:

- `DB_HOST=db` - Nome do serviço MySQL no Docker
- `DB_PORT=3306` - Porta interna do MySQL
- `DB_DATABASE=news_platform` - Nome do banco de dados
- `DB_USERNAME=laravel` - Usuário do banco
- `DB_PASSWORD=secret` - Senha do banco

### Passo 3: Subir os Containers

```bash
docker-compose up -d
```

Este comando irá:

✅ Construir a imagem PHP-FPM com Laravel
✅ Inicializar o servidor Nginx  
✅ Criar o servidor MySQL 8.0
✅ Criar a rede Docker para comunicação entre serviços

### Passo 4: Executar Migrations

```bash
docker-compose exec app php artisan migrate
```

Isso criará todas as tabelas do banco de dados necessárias para a aplicação.

### Passo 5: Acessar a Aplicação

A aplicação estará disponível em:

🌐 **http://localhost:8080**

---

## 📊 Arquitetura dos Containers

### Serviços Disponíveis

| Serviço | Imagem | Porta Interna | Porta Externa | Descrição |
|---------|--------|---------------|---------------|-----------| 
| **app** | PHP 8.3-FPM | 9000 | - | Aplicação Laravel |
| **nginx** | Alpine | 80 | 8080 | Servidor Web |
| **db** | MySQL 8.0 | 3306 | 3306 | Banco de Dados |

### Rede Docker

Todos os containers estão na rede `news-network` (bridge), permitindo comunicação interna pelo nome do serviço.

---

## 🛠️ Comandos Úteis

### Verificar Status dos Containers

```bash
docker-compose ps
```

### Ver Logs de um Serviço

```bash
# Todos os serviços
docker-compose logs

# Apenas um serviço
docker-compose logs app
docker-compose logs nginx
docker-compose logs db
```

### Acessar o Container da Aplicação

```bash
docker-compose exec app sh
```

### Executar Artisan Commands

```bash
# Listar migrations
docker-compose exec app php artisan migrate:status

# Fazer rollback das migrations
docker-compose exec app php artisan migrate:rollback

# Visualizar rotas
docker-compose exec app php artisan route:list
```

### Reiniciar Containers

```bash
# Reiniciar todos
docker-compose restart

# Reiniciar um serviço específico
docker-compose restart app
docker-compose restart nginx
docker-compose restart db
```

### Parar a Aplicação

```bash
# Parar containers (dados persistem)
docker-compose stop

# Derrubar containers (remove volumes locais, não persiste dados)
docker-compose down

# Derrubar removendo volume de dados do banco
docker-compose down -v
```

---

## 💾 Persistência de Dados

### Banco de Dados

O MySQL usa um volume Docker nomeado `db_data` para armazenar dados:

```yaml
volumes:
  db_data:
```

**Importante:** Os dados persistem entre:
- `docker-compose up/down` ✅
- Reinicializações dos containers ✅

Os dados são **removidos** apenas com:
```bash
docker-compose down -v
```

### Aplicação

O código-fonte está mapeado como volume, então mudanças locais refletem imediatamente nos containers:

```yaml
volumes:
  - .:/var/www
```

---

## 🔧 Troubleshooting

### Problema: Porta 8080 já em uso

**Solução:** Modificar a porta no `docker-compose.yml`:

```yaml
nginx:
  ports:
    - "8888:80"  # Agora em http://localhost:8888
```

### Problema: Erro de permissões no storage

**Solução:** Executar:

```bash
docker-compose exec app sh -c "chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"
```

### Problema: Banco não inicializa

**Solução:** Verificar logs e remover volume:

```bash
docker-compose logs db
docker-compose down -v
docker-compose up -d
```

### Problema: Conexão recusada ao banco

**Solução:** Aguardar o MySQL inicializar (alguns segundos) e tentar novamente:

```bash
docker-compose logs db | tail -20
```

---

## 📝 Estrutura do Projeto

```
news-platform/
├── docker/
│   ├── php/
│   │   └── Dockerfile          # Configuração da imagem PHP
│   └── nginx/
│       └── nginx.conf           # Configuração do servidor web
├── docker-compose.yml           # Orquestração dos containers
├── app/                         # Aplicação Laravel
├── config/                      # Arquivos de configuração
├── database/                    # Migrations e seeders
├── resources/                   # Assets e views
├── routes/                      # Definição de rotas
├── src/                         # Código modular (DDD)
├── tests/                       # Testes automatizados
└── .env                         # Variáveis de ambiente
```

---

## ✅ Verificação de Conectividade

### Testar Aplicação

```bash
curl http://localhost:8080
```

### Testar Banco de Dados

```bash
docker-compose exec db mysql -u laravel -psecret -e "SELECT 1;" news_platform
```

### Verificar Resolução de DNS Interno

```bash
docker-compose exec app ping db
docker-compose exec app ping nginx
```

---

## 🔐 Segurança

⚠️ **Importante para Produção:**

Os valores de senha/credenciais no `.env` são apenas para **desenvolvimento local**. Em produção:

- Usar variáveis de ambiente seguras
- Modificar `DB_PASSWORD` para uma senha forte
- Usar HTTPS (certificado SSL)
- Implementar authentication/authorization adequada
- Não versionar `.env` no Git

---

## 📚 Recursos Adicionais

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## 💬 Suporte

Para dúvidas ou problemas:

1. Verificar a documentação acima
2. Consultar `docker-compose logs`
3. Verificar se os ports estão disponíveis
4. Reiniciar Docker Desktop se necessário

