# API REST - Gerenciamento de Estoque

Projeto desenvolvido com Laravel 11 para atender a atividade de construcao de uma API REST para gerenciamento de estoque, usando SQLite para facilitar execucao local.

## Objetivo da atividade

Implementar uma API com foco em:

- arquitetura limpa
- validacao estrita de entrada
- uso exclusivo de Eloquent ORM (sem SQL manual)
- respostas JSON padronizadas
- status HTTP corretos para cada operacao
- testes automatizados de feature cobrindo 200, 201, 404 e 422

## Stack tecnica

- PHP 8.3.17
- Laravel 11.51.0
- SQLite
- Eloquent ORM
- PHPUnit (Feature Tests)

## Escopo implementado

### 1) Banco de dados

- Conexao via SQLite no arquivo .env
- Arquivo de banco: database/database.sqlite

### 2) Migration e Model

Tabela products:

- id
- nome (string)
- quantidade (integer)
- preco (decimal 8,2)
- created_at e updated_at

Model Product com mass assignment seguro:

- fillable: nome, quantidade, preco

### 3) Controller e regras de negocio

Controller de API com CRUD:

- index: lista produtos (200)
- store: cria produto com validacao (201)
- show: retorna produto por id (200 ou 404)
- update: atualiza produto existente (200 ou 404)
- destroy: remove produto existente (200 ou 404)

Validacao aplicada via FormRequest:

- nome: required, string, max:255
- quantidade: required, integer, min:0
- preco: required, numeric, min:0

Erros de validacao retornam:

- status 422
- JSON com message e errors

### 4) Rotas da API

Exposicao de recurso com Route::apiResource em routes/api.php.

## Interface visual

A rota web raiz (/) foi customizada para um painel visual do projeto de estoque (nao exibe mais a tela padrao do Laravel).

Recursos da tela:

- dashboard com metricas
- formulario para criar/editar produtos
- tabela com listagem e exclusao
- consumo da API /api/products

## Estrutura principal de arquivos

- app/Models/Product.php
- app/Http/Controllers/Api/ProductController.php
- app/Http/Requests/ApiFormRequest.php
- app/Http/Requests/Product/StoreProductRequest.php
- app/Http/Requests/Product/UpdateProductRequest.php
- database/migrations/2026_04_08_000000_create_products_table.php
- routes/api.php
- tests/Feature/ProductApiTest.php

## Como executar localmente (Windows / PowerShell)

### Pre requisitos

- PHP 8.3 no caminho C:\tools\php83\php.exe
- Composer local (composer.phar na raiz do projeto)

### Passo a passo

```powershell
cd C:\PROJETOS\php-projeto

C:\tools\php83\php.exe composer.phar install

if (!(Test-Path .env)) { Copy-Item .env.example .env }
if (!(Test-Path .\database\database.sqlite)) { New-Item -ItemType File -Path .\database\database.sqlite | Out-Null }

C:\tools\php83\php.exe artisan key:generate
C:\tools\php83\php.exe artisan migrate

C:\tools\php83\php.exe artisan serve
```

Aplicacao web:

- http://127.0.0.1:8000

API:

- http://127.0.0.1:8000/api/products

## Configuracao .env para SQLite

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
DB_FOREIGN_KEYS=true
```

## Endpoints da API

| Metodo | Endpoint | Descricao | Status |
|---|---|---|---|
| GET | /api/products | Lista todos os produtos | 200 |
| POST | /api/products | Cria um produto | 201, 422 |
| GET | /api/products/{id} | Busca um produto | 200, 404 |
| PUT/PATCH | /api/products/{id} | Atualiza um produto | 200, 404, 422 |
| DELETE | /api/products/{id} | Remove um produto | 200, 404 |

## Padrao de resposta JSON

Sucesso:

```json
{
  "message": "Produto criado com sucesso.",
  "data": {
    "id": 1,
    "nome": "Teclado",
    "quantidade": 10,
    "preco": "199.90",
    "created_at": "...",
    "updated_at": "..."
  }
}
```

Erro de validacao:

```json
{
  "message": "Falha de validacao.",
  "errors": {
    "nome": ["The nome field is required."],
    "quantidade": ["The quantidade field is required."],
    "preco": ["The preco field is required."]
  }
}
```

Recurso nao encontrado:

```json
{
  "message": "Produto nao encontrado.",
  "errors": null
}
```

## Testes automatizados (Feature)

Arquivo de testes:

- tests/Feature/ProductApiTest.php

Cenarios cobertos:

- 200: index, update existente, destroy existente
- 201: store valido
- 404: update inexistente, destroy inexistente
- 422: store invalido

Executar testes:

```powershell
cd C:\PROJETOS\php-projeto
C:\tools\php83\php.exe artisan test --filter=ProductApiTest --env=testing
```

## Observacoes

- O projeto utiliza Eloquent em todas as operacoes de persistencia.
- Nao ha SQL manual no codigo da API.
- O ambiente de teste utiliza SQLite em memoria via phpunit.xml.
