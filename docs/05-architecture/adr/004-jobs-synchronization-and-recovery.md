# ADR-004 — Jobs, sincronização e recuperação de falhas

**Status:** Aceita
**Data:** 2026-10-09

## Contexto

O Comentaro precisa consultar integrações periodicamente e executar análise, notificação, geração por IA e publicação de respostas sem bloquear requisições da API. Repetições, atrasos e falhas externas não podem duplicar interações ou efeitos.

O volume do MVP ainda não justifica Redis, Horizon ou infraestrutura separada para workers.

## Decisão

Usar Laravel Queue com PostgreSQL como mecanismo inicial de fila e Laravel Scheduler para disparar a seleção de integrações a cada minuto. A frequência inicial de cada integração será uma hora.

Separar jobs por responsabilidade: coordenação da sincronização, captura de avaliações, processamento da interação, notificação, sugestão por IA, publicação e reconciliação de resposta.

Permitir apenas uma sincronização simultânea por integração, usando bloqueio com expiração. Integrações diferentes podem executar em paralelo.

Consultar uma margem de cinco minutos antes do último checkpoint confirmado. Garantir unicidade da interação por provedor, conta externa e identificador externo. Efeitos como notificação e publicação de resposta terão chaves próprias de idempotência.

Aplicar no máximo cinco tentativas com execução imediata e esperas de 1 minuto, 5 minutos, 15 minutos e 1 hora. Erros permanentes interrompem retentativas e exigem ação. Resultados incertos de publicação são reconciliados com o provedor antes de novo envio.

Persistir o estado e o histórico sanitizado de cada tentativa. Os estados de sincronização serão `pending`, `running`, `succeeded`, `partially_failed`, `failed` e `requires_action`.

## Alternativas consideradas

### Execução síncrona durante requisições HTTP

Rejeitada porque tempos e falhas de provedores externos degradariam a API e dificultariam retomadas seguras.

### Redis e Laravel Horizon no MVP

Adiados porque PostgreSQL atende ao volume inicial com menos componentes e menor custo operacional.

### Uma única rotina para toda a jornada

Rejeitada porque acoplaria captura, análise, notificação, IA e resposta. Estados e recuperações precisam permanecer independentes.

### Banco NoSQL ou vetorial

Não são necessários para durabilidade, idempotência ou histórico deste fluxo.

## Consequências

- O banco também sustentará a fila inicial e deverá ser monitorado quanto a contenção e crescimento.
- Jobs precisam ser idempotentes e seguros para reexecução.
- Checkpoints avançam apenas depois da persistência correspondente.
- Falhas finais permanecem visíveis e permitem nova tentativa segura.
- Redis, Horizon e workers separados poderão ser introduzidos sem mudar as regras da jornada.
- O MVP usa a frequência de uma hora; opções adicionais serão avaliadas após a entrada em produção.
