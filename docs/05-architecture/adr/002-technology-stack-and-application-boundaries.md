# ADR-002 — Stack tecnológica e separação entre frontend e backend

**Status:** Aceita
**Data:** 2026-10-09

## Contexto

O Comentaro precisa de uma API que concentre regras de negócio, isolamento por organização, integrações externas, sincronizações, filas, notificações e respostas. A interface web deve evoluir e ser implantada independentemente do backend.

A experiência principal da equipe está em PHP. O projeto também será desenvolvido com assistência de agentes, o que favorece tecnologias convencionais, contratos explícitos, feedback automatizado e uma quantidade controlada de componentes operacionais.

## Decisão

Manter frontend e backend como aplicações independentes, inicialmente no mesmo repositório:

```text
apps/
├── api/
└── web/
```

O backend será um monólito modular construído com PHP 8.5 e Laravel 13. Ele exporá uma API REST em JSON, versionada a partir de `/api/v1`. PostgreSQL será a fonte de verdade. Laravel Queue, inicialmente com o driver de banco de dados, executará trabalhos assíncronos, e Laravel Scheduler coordenará tarefas recorrentes. Pest será usado nos testes do backend.

O frontend será uma aplicação independente construída com React 19, TypeScript e Vite. React Router cuidará das rotas, TanStack Query do estado remoto, Tailwind CSS dos estilos e shadcn/ui dos componentes de interface. Vitest será usado nos testes do frontend.

OpenAPI será o contrato entre as aplicações e servirá para gerar ou validar os tipos TypeScript consumidos pelo frontend. A autenticação web usará Laravel Sanctum com cookies seguros. Autorização e isolamento por organização serão sempre aplicados pelo backend.

O ambiente local será coordenado com Docker Compose. Laravel Boost será usado como apoio ao desenvolvimento do backend por agentes.

## Alternativas consideradas

### Laravel com Livewire

Não atende à separação requerida entre frontend e backend, pois a interface e o ciclo de requisição permanecem ligados à aplicação Laravel.

### React com Next.js

Não foi escolhido para o MVP porque a área autenticada não requer renderização no servidor ou SEO que justifiquem sua complexidade adicional.

### Repositórios separados desde o início

Não foi escolhido porque um monorepo mantém contrato, documentação e mudanças correlatas no mesmo fluxo. As aplicações preservam dependências, builds e implantações independentes e podem ser separadas em repositórios no futuro.

### Redis e Laravel Horizon desde o início

Adiados até existir volume ou necessidade operacional. A fila em PostgreSQL reduz componentes e custo no MVP.

## Consequências

- Frontend e backend possuem dependências, builds e implantações independentes.
- O monólito modular descrito no ADR-001 se aplica ao backend.
- O frontend só acessa capacidades do backend pela API publicada.
- Credenciais do iFood e demais provedores permanecem exclusivamente no backend.
- Mudanças de contrato devem atualizar a especificação OpenAPI e seus consumidores.
- O frontend estático e a API podem compartilhar uma VPS inicialmente sem perder a separação arquitetural.
- Redis, Horizon, banco gerenciado e separação física de workers permanecem opções de evolução.
