# Arquitetura — estado inicial

O Comentaro terá frontend e backend independentes. O backend será um monólito modular, dividido internamente por módulos de negócio com limites explícitos e camadas pragmáticas. As duas aplicações permanecerão inicialmente no mesmo repositório, com dependências, builds e implantações independentes.

## Forma e camadas

Cada módulo separa domínio, aplicação e adaptadores na medida necessária para proteger regras e dependências externas. A direção das dependências aponta para o núcleo do módulo. Não será aplicada uma versão cerimonial de Clean Architecture com abstrações sem uso concreto.

Módulos se comunicam por contratos públicos de aplicação ou eventos explícitos. Um módulo não acessa diretamente repositórios, tabelas internas ou adaptadores de outro.

Consulte [modular-monolith.md](modular-monolith.md), [ADR-001](adr/001-modular-monolith.md), [ADR-002](adr/002-technology-stack-and-application-boundaries.md), [ADR-003](adr/003-spa-authentication.md), [ADR-004](adr/004-jobs-synchronization-and-recovery.md) e [ADR-005](adr/005-transactional-email.md).

## Diretriz de isolamento

`Organization` é o limite de acesso aos dados desde o MVP. Toda operação autenticada deve derivar a organização do usuário autenticado e restringir consultas e alterações a ela. A estratégia técnica será definida na arquitetura.

## Diretriz de integrações

O módulo `Connections` gerencia integrações e expõe capacidades independentes do provedor. Cada provedor possui um conector. Credenciais da aplicação e tokens permanecem no servidor; associações de contas externas pertencem às organizações e unidades autorizadas.

## Diretriz de sincronização

Sincronizações são trabalhos retomáveis e idempotentes por integração. O progresso só avança depois da persistência, e uma falha em uma loja não bloqueia outras. A solução deve oferecer agendamento, execução durável, retentativas controladas e observabilidade.

PostgreSQL será a fonte de verdade do MVP. Laravel Queue, inicialmente com o driver de banco de dados, executará trabalhos assíncronos, e Laravel Scheduler coordenará tarefas recorrentes. Banco vetorial não faz parte desta responsabilidade.

Consulte [integrations.md](integrations.md) para o desenho conceitual e as restrições verificadas do iFood.

## Stack definida

- Backend: PHP 8.5, Laravel 13, API REST JSON, Laravel Queue, Laravel Scheduler e Pest.
- Frontend: React 19, TypeScript, Vite, React Router, TanStack Query, Tailwind CSS, shadcn/ui e Vitest.
- Contrato: OpenAPI, com tipos TypeScript gerados ou validados a partir da especificação.
- Persistência: PostgreSQL.
- Autenticação web: Laravel Sanctum com sessão em cookie seguro, proteção CSRF e revogação no servidor.
- Ambiente local: Docker Compose.
- Organização física inicial: monorepo com `apps/api` e `apps/web`.

## Decisões pendentes

- Provedor de hospedagem e topologia de produção.
- Implementação dos controles e testes contra acesso entre organizações.
- Plataforma externa de monitoramento e alertas operacionais.
- Provedor de IA.

Consulte [transactional-email.md](transactional-email.md) para a arquitetura de e-mail e os estados de entrega.

Decisões técnicas futuras devem ser justificadas e registradas em `adr/` antes de guiar a implementação.
