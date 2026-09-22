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

**Status:** Aceita parcialmente

A nota da avaliação é o sinal principal para determinar prioridade. O texto do comentário será analisado para inferir o nível de satisfação, mantido como informação separada. As faixas de prioridade e a escala de satisfação ainda precisam ser definidas.

## DEC-008 — Responsável pela jornada

**Status:** Aceita

O responsável pelo estabelecimento recebe as notificações e é o perfil autorizado a preparar e enviar a resposta.

## DEC-009 — Tratamento de falhas

**Status:** Aceita

Quando uma etapa falhar, o Comentaro deve exibir o estado da interação, permitir uma nova tentativa segura e registrar o ocorrido no histórico.
