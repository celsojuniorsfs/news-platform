# Arquitetura Base

## Estratégia

O projeto será construído como um monólito modular em Laravel 12.

## Diretrizes

- separação por bounded context
- isolamento por módulo
- regras de domínio no centro
- controllers e Eloquent fora da camada de domínio
- casos de uso explícitos na camada de aplicação
- infraestrutura isolada

## Módulos iniciais

### News
Responsável por:
- cadastro de notícia
- edição de notícia
- listagem de notícia
- busca por título
- associação com categoria

### Category
Responsável por:
- cadastro de categoria
- listagem de categorias

## Estrutura por módulo

```txt
src/News
├─ Application
├─ Domain
├─ Infrastructure
└─ Presentation
