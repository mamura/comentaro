# API do Comentaro

Backend do Comentaro em Laravel, organizado como monolito modular. A API expõe contratos versionados em `/api/v1` e usa autenticação web baseada em sessão com Laravel Sanctum.

## Requisitos locais

O fluxo recomendado usa Docker Compose a partir da raiz do repositório. Para executar diretamente no WSL, use PHP 8.5, Composer 2 e PostgreSQL 17.

## Comandos

```bash
composer test
composer lint
composer analyse
php artisan route:list
```

O endpoint inicial de diagnóstico é `GET /api/v1/health`.

## Organização

- `app/Modules`: módulos do negócio e suas fronteiras.
- `routes/api.php`: rotas HTTP versionadas.
- `database/migrations`: evolução do banco relacional.
- `tests`: testes Pest.

Consulte o [README principal](../../README.md), o [contrato OpenAPI](../../contracts/openapi.yaml) e a documentação em `docs/` antes de implementar funcionalidades.
