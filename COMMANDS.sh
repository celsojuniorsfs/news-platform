#!/bin/bash

# 🚀 News Platform - Quick Commands Script
# Este arquivo contém os comandos mais usados durante o desenvolvimento

echo "📋 News Platform - Comandos Disponíveis"
echo "========================================"
echo ""
echo "🟢 INICIALIZAÇÃO"
echo "  docker-compose up -d              # Subir ambiente"
echo "  docker-compose exec app php artisan migrate  # Rodar migrations"
echo ""
echo "🟡 DESENVOLVIMENTO"
echo "  docker-compose exec app sh        # Acessar container PHP"
echo "  docker-compose logs -f app        # Ver logs da aplicação"
echo "  docker-compose logs -f nginx      # Ver logs do nginx"
echo "  docker-compose logs -f db         # Ver logs do banco"
echo ""
echo "🔴 LIMPEZA"
echo "  docker-compose down               # Desligar containers"
echo "  docker-compose down -v            # Desligar e remover volumes"
echo "  docker-compose restart            # Reiniciar todos os serviços"
echo ""
echo "🧪 TESTES"
echo "  docker-compose exec app php artisan test  # Rodar testes"
echo ""
echo "📊 BANCO DE DADOS"
echo "  docker-compose exec db mysql -u laravel -psecret news_platform"
echo ""
echo "ℹ️  Para mais informações, veja DOCKER_SETUP.md"

