# Registro de decisões de produto

## DEC-001 — Alcance do monitoramento

**Status:** Aceita

A visão inclui interações nos canais próprios conectados e menções públicas externas. O MVP começa apenas com interações diretamente associadas aos canais conectados.

## DEC-002 — Primeiro vertical

**Status:** Aceita

Restaurantes são o primeiro vertical. O modelo de domínio deve continuar aplicável a outros negócios.

## DEC-003 — Estrutura conceitual

**Status:** Aceita

Usar `Organization > Location > Integration > Interaction`. `Interaction` é a entidade central, abrangendo tipos de interação que não se limitam a avaliações.

## DEC-004 — Tratamento de casos críticos

**Status:** Adiada

O MVP não classifica nem aplica um fluxo especial a casos críticos. A regra será reconsiderada quando existirem exemplos reais suficientes para definir critérios confiáveis.

## DEC-005 — Arquitetura técnica

**Status:** Pendente

Stack, desenho de componentes, persistência, hospedagem e provedores não foram decididos nem implementados.

## DEC-006 — Primeiro canal

**Status:** Aceita

O iFood será o primeiro canal de integração. No primeiro recorte, as interações capturadas desse canal são avaliações associadas aos estabelecimentos conectados.

## DEC-007 — Prioridade e satisfação

**Status:** Aceita

A nota determina a prioridade inicial: 1 ou 2 estrelas resulta em prioridade alta, 3 em média e 4 ou 5 em baixa.

O texto é analisado separadamente para inferir satisfação como muito insatisfeito, insatisfeito, neutro, satisfeito, muito satisfeito ou indeterminado. A análise também informa confiança baixa, média ou alta. Com confiança baixa, a satisfação é apresentada como indeterminada ou como classificação que precisa de revisão.

## DEC-008 — Responsável pela jornada

**Status:** Aceita

O responsável pelo estabelecimento recebe as notificações e é o perfil autorizado a preparar e enviar a resposta.

## DEC-009 — Tratamento de falhas

**Status:** Aceita

Quando uma etapa falhar, o Comentaro deve exibir o estado da interação, permitir uma nova tentativa segura e registrar o ocorrido no histórico.

## DEC-010 — Configuração de notificações

**Status:** Aceita parcialmente

No MVP, a notificação é configurada por estabelecimento com dois estados: ativa ou silenciada. Quando ativa, novas avaliações geram notificação para o responsável. Quando silenciada, as avaliações continuam sendo capturadas e exibidas, mas não geram aviso externo. O canal de entrega e o estado inicial ainda serão definidos.

## DEC-011 — Sugestão de resposta por IA

**Status:** Aceita

O MVP deve incluir sugestão de resposta por IA, com prioridade de implementação inferior ao fluxo principal de captura, análise, notificação e resposta. A sugestão deve ser revisável e editável pelo responsável e nunca será publicada automaticamente.
