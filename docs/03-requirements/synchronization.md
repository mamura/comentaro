# Sincronização de avaliações

## Carga inicial

- A janela é móvel: dos 30 dias anteriores ao início da ativação até o momento da consulta.
- No máximo 100 avaliações são importadas.
- Quando houver mais de 100 avaliações no período, são mantidas as 100 mais recentes.
- A API do iFood aceita no máximo 50 itens por página; o limite de 100 exige até duas páginas completas.
- A carga usa filtros de data em ISO 8601 e ordenação decrescente por criação.
- Avaliações históricas da carga inicial não geram notificação.
- Cada avaliação é identificada pelo provedor, `merchantId` e ID externo para impedir duplicidade.

## Sincronização periódica

- Cada integração ativa agenda sincronizações na frequência configurada.
- A frequência inicial é de uma hora.
- A execução busca dados a partir do último ponto confirmado, com margem de sobreposição técnica para cobrir atrasos do provedor.
- Itens já conhecidos são reconciliados de forma idempotente em vez de duplicados.
- O checkpoint só avança depois que os itens correspondentes estiverem persistidos.
- Uma execução da mesma integração não deve ocorrer simultaneamente com outra.

## Estados da sincronização

| Estado | Significado |
| --- | --- |
| `idle` | Sem execução em andamento. |
| `scheduled` | Próxima execução aguardando processamento. |
| `running` | Consulta e persistência em andamento. |
| `succeeded` | Última execução concluída e checkpoint confirmado. |
| `retry_wait` | Falha transitória aguardando nova tentativa. |
| `failed` | Retentativas esgotadas ou erro que requer ação. |

O usuário deve poder consultar o horário e o resultado da última sincronização e o horário previsto da próxima.

## Garantias

- Nenhuma avaliação deve ser duplicada por repetição de página, sobreposição, retentativa ou execução atrasada.
- Uma falha parcial não pode avançar o checkpoint além do último lote persistido.
- A retomada começa de um ponto confirmado e pode reler uma janela anterior.
- Reprocessar uma avaliação conhecida pode atualizar seu estado externo e respostas sem apagar o histórico local.
- Uma falha em uma integração não bloqueia outras integrações.

## Evolução futura

Uma ação explícita poderá buscar avaliações anteriores à janela inicial. Ela deve ter limites, progresso e tratamento de notificações próprios antes de ser implementada.

## Fonte externa

Verificado em 23 de setembro de 2026: a Review API V2 oferece filtros `dateFrom` e `dateTo`, paginação e limite máximo de 50 itens por página. Consulte os [critérios oficiais de homologação](https://developer.ifood.com.br/pt-BR/docs/guides/modules/review/homologation).
