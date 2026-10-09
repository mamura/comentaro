# Sincronização de avaliações

## Carga inicial

- A janela é móvel: dos 30 dias anteriores ao início da ativação até o momento da consulta.
- No máximo 100 avaliações são importadas.
- Quando houver mais de 100 avaliações no período, são mantidas as 100 mais recentes.
- A API do iFood aceita no máximo 50 itens por página; o limite de 100 exige até duas páginas completas.
- A carga usa filtros de data em ISO 8601 e ordenação decrescente por criação.
- Avaliações históricas da carga inicial não geram notificação.
- Cada avaliação é identificada pelo provedor, conta externa e ID externo para impedir duplicidade.

## Sincronização periódica

- O Laravel Scheduler verifica a cada minuto quais integrações possuem `next_sync_at` vencido.
- Uma integração ativa começa com frequência de uma hora.
- A execução busca dados a partir de cinco minutos antes do último ponto confirmado.
- Itens já conhecidos são reconciliados de forma idempotente em vez de duplicados.
- O checkpoint só avança depois que os itens correspondentes estiverem persistidos.
- O próximo horário é registrado como parte do controle da tentativa.
- Apenas uma sincronização pode executar simultaneamente por integração.
- Integrações diferentes podem executar em paralelo.
- O bloqueio por integração possui expiração para permitir recuperação depois de interrupções.

No MVP, a frequência permanece em uma hora. Opções adicionais e um eventual menor intervalo serão configurados depois da entrada em produção, com base em dados operacionais e nos limites da API.

## Jobs

| Job conceitual | Responsabilidade |
| --- | --- |
| `SynchronizeIntegration` | Coordenar uma execução de sincronização da integração. |
| `FetchReviews` | Consultar e persistir avaliações do provedor. |
| `ProcessInteraction` | Calcular prioridade, satisfação e confiança. |
| `SendInteractionNotification` | Entregar a notificação por e-mail. |
| `GenerateReplySuggestion` | Gerar uma sugestão de resposta por IA. |
| `PublishReply` | Solicitar o envio da resposta ao provedor. |
| `ReconcileReply` | Consultar o provedor depois de um envio com resultado incerto. |

Esses nomes expressam responsabilidades e podem ser ajustados à convenção final do código. Falhas em análise, e-mail ou IA não impedem operações independentes.

## Idempotência

Uma interação externa possui unicidade por:

```text
provider + external_account + external_interaction_id
```

Notificação, publicação de resposta e demais efeitos externos possuem chaves de idempotência próprias. Reexecutar um job não pode duplicar a interação nem repetir um efeito já confirmado.

Antes de repetir uma resposta com resultado incerto, `ReconcileReply` consulta o provedor.

## Retentativas

O máximo inicial é de cinco tentativas por job:

| Tentativa | Espera |
| ---: | ---: |
| 1 | imediata |
| 2 | 1 minuto |
| 3 | 5 minutos |
| 4 | 15 minutos |
| 5 | 1 hora |

Erros transitórios seguem essa espera progressiva. Erros permanentes, como autorização revogada ou acesso negado, interrompem as retentativas automáticas e colocam a integração em `requires_action`.

Depois de esgotar as tentativas, o job permanece registrado como falho, o estado fica visível e uma nova tentativa segura pode ser solicitada.

## Estados da sincronização

| Estado | Significado |
| --- | --- |
| `pending` | Execução registrada e aguardando processamento. |
| `running` | Consulta ou persistência em andamento. |
| `succeeded` | Execução concluída e checkpoint confirmado. |
| `partially_failed` | Parte do trabalho foi persistida, mas existe falha registrada e recuperável. |
| `failed` | Tentativas esgotadas ou execução encerrada sem sucesso. |
| `requires_action` | A continuação depende de ação, como renovar uma autorização. |

O usuário deve consultar o horário e o resultado da última sincronização e o horário previsto da próxima.

## Histórico de execução

Cada tentativa registra:

- integração;
- início e término;
- intervalo consultado;
- quantidade recebida;
- quantidade criada e atualizada;
- resultado;
- número da tentativa;
- categoria e mensagem sanitizada do erro;
- próximo horário previsto;
- identificador de correlação.

Segredos, tokens e conteúdo sensível desnecessário não entram no histórico nem nos logs.

## Garantias

- Nenhuma avaliação deve ser duplicada por repetição de página, sobreposição, retentativa ou execução atrasada.
- Uma falha parcial não pode avançar o checkpoint além do último lote persistido.
- A retomada começa de um ponto confirmado e pode reler a margem de cinco minutos.
- Reprocessar uma avaliação conhecida pode atualizar seu estado externo e respostas sem apagar o histórico local.
- Uma falha em uma integração não bloqueia outras integrações.
- Redis e Laravel Horizon não fazem parte da infraestrutura inicial.

## Evolução futura

Uma ação explícita poderá buscar avaliações anteriores à janela inicial. Ela deve ter limites, progresso e tratamento de notificações próprios antes de ser implementada.

Redis, Laravel Horizon e workers fisicamente separados serão avaliados quando volume, concorrência ou necessidade operacional justificarem.

## Fonte externa

Verificado em 23 de setembro de 2026: a Review API V2 oferece filtros `dateFrom` e `dateTo`, paginação e limite máximo de 50 itens por página. Consulte os [critérios oficiais de homologação](https://developer.ifood.com.br/pt-BR/docs/guides/modules/review/homologation).
