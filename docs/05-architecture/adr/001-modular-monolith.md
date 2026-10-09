# ADR-001 — Monólito modular com camadas pragmáticas

**Status:** Aceita
**Data:** 2026-10-09

## Contexto

O MVP reúne autenticação, organizações, conexões externas, sincronização, análise, notificações e respostas. Esses fluxos possuem limites de negócio diferentes, mas ainda não existe volume, equipe ou necessidade operacional que justifique distribuição em vários serviços.

O projeto precisa manter regras e integrações externas organizadas para permitir evolução por vibecoding sem misturar responsabilidades. Ao mesmo tempo, aplicar todas as abstrações de uma Clean Architecture formal aumentaria código, decisões e manutenção antes de existir necessidade comprovada.

## Decisão

Adotar uma única unidade de implantação organizada como monólito modular.

O código será organizado primeiro por módulo de negócio. Dentro de cada módulo, serão separadas as responsabilidades de domínio, aplicação e adaptadores quando essa separação proteger regras, dependências externas ou casos de uso.

Dependências apontam para o núcleo do módulo. Comunicação entre módulos ocorre por contratos públicos de aplicação ou eventos explícitos. Acesso direto às implementações internas ou aos repositórios de outro módulo não é permitido.

Princípios de código limpo serão aplicados de forma pragmática: nomes claros, responsabilidades coesas, validação explícita, dependências visíveis e abstrações justificadas. Interfaces e camadas sem comportamento ou fronteira real não são obrigatórias.

## Alternativas consideradas

### Aplicação organizada apenas por camadas globais

Rejeitada porque tende a espalhar um mesmo fluxo por pastas genéricas e enfraquecer os limites de negócio conforme a aplicação cresce.

### Microserviços

Rejeitados para o MVP por acrescentarem implantação, observabilidade, comunicação distribuída e consistência operacional sem benefício proporcional nesta fase.

### Clean Architecture completa em todos os fluxos

Rejeitada como regra obrigatória. Partes críticas podem usar separação mais rigorosa, mas operações simples não precisam de abstrações cerimoniais.

## Consequências

- Uma implantação simplifica desenvolvimento e operação do MVP.
- Limites modulares exigem disciplina e, depois da escolha da stack, verificações automatizadas quando viáveis.
- O banco pode ser fisicamente compartilhado, mas a propriedade lógica dos dados permanece com o módulo.
- Transações locais continuam simples.
- Extração futura de um módulo permanece possível, mas não é objetivo atual.
- A stack deverá permitir organização por módulos e testes dos limites escolhidos.
