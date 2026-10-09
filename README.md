# Comentaro

Comentaro é uma central de reputação e atendimento multicanal. A visão é acompanhar interações ligadas aos canais da organização e, futuramente, menções públicas externas. O MVP começa pelas avaliações do iFood associadas aos estabelecimentos conectados.

O primeiro vertical é o de restaurantes, mas o domínio deve servir a outros tipos de negócio. A unidade central do produto é a `Interaction`.

## Estado do projeto

A fundação técnica está criada. Frontend e backend são aplicações independentes no mesmo repositório:

```text
apps/
├── api/   Laravel 13 e PHP 8.5
└── web/   React 19, TypeScript e Vite
```

PostgreSQL é a fonte de verdade, OpenAPI é o contrato entre as aplicações e Docker Compose coordena o ambiente local. A próxima entrega funcional é cadastro, autenticação e isolamento por organização.

## Ambiente local

Pré-requisitos:

- Docker com Compose;
- `make`, disponível no WSL;
- portas 5173, 8000, 8025, 1025 e 5432 livres.

Preparação:

```bash
make setup
make up
```

Serviços:

- aplicação web: http://localhost:5173;
- API: http://localhost:8000/api/v1/health;
- Mailpit: http://localhost:8025.

Comandos principais:

```bash
make test
make lint
make format
make generate-api
make logs
make down
```

Os tipos TypeScript em `apps/web/src/api/schema.d.ts` são gerados a partir de `contracts/openapi.yaml`.

## Documentação

- [Produto](docs/01-product/vision.md) e [escopo](docs/01-product/scope.md)
- [Problema e hipóteses](docs/02-discovery/problem.md) e [decisões](docs/02-discovery/decisions.md)
- [Jornadas](docs/03-requirements/user-journeys.md)
- [Modelo de domínio](docs/04-domain/domain-model.md)
- [Arquitetura](docs/05-architecture/overview.md)
- [Planejamento](docs/06-planning/roadmap.md)

Leia [AGENTS.md](AGENTS.md) antes de propor implementação.
