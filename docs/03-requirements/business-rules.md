# Regras de negócio iniciais

## Regras aceitas

### RN-001 — Origem da interação

No primeiro recorte, uma interação é uma avaliação do iFood vinculada a um estabelecimento conectado.

### RN-002 — Prioridade pela nota

- 1 ou 2 estrelas: prioridade alta.
- 3 estrelas: prioridade média.
- 4 ou 5 estrelas: prioridade baixa.

A análise do comentário não altera automaticamente essa prioridade no MVP.

### RN-003 — Satisfação inferida

O texto do comentário é classificado como muito insatisfeito, insatisfeito, neutro, satisfeito, muito satisfeito ou indeterminado. O resultado permanece separado da nota e da prioridade.

A análise informa confiança baixa, média ou alta. Quando a confiança for baixa, o sistema apresenta a satisfação como indeterminada ou sinaliza que a classificação precisa de revisão.

### RN-004 — Casos críticos

O MVP não classifica casos críticos nem cria um fluxo especial para eles. Essa regra só será definida depois da análise de exemplos reais.

### RN-005 — Configuração de notificação

A notificação é configurada por estabelecimento como ativa ou silenciada.

- Ativa: cada nova avaliação capturada gera uma notificação para o responsável pelo estabelecimento.
- Silenciada: a avaliação continua sendo capturada e exibida, sem envio de notificação externa.

Alterar essa configuração afeta apenas avaliações capturadas depois da alteração. O canal de entrega e o estado inicial ainda precisam ser definidos.

### RN-006 — Responsável pela resposta

O mesmo perfil responsável pelo estabelecimento prepara e envia a resposta.

### RN-007 — Sugestão de resposta por IA

O sistema pode gerar uma sugestão de resposta, que deve permanecer editável. O responsável decide se a utiliza e confirma qualquer envio. O sistema não publica automaticamente uma sugestão.

### RN-008 — Falha visível

Uma falha deve deixar visível o estado atual da interação e ser registrada no histórico com a etapa afetada e o resultado conhecido.

### RN-009 — Nova tentativa segura

Quando uma operação puder ser repetida, a nova tentativa não deve duplicar a avaliação, a notificação ou a resposta. O resultado de cada tentativa deve integrar o histórico.

### RN-010 — Restrição de resposta do iFood

Antes de oferecer ou executar o envio, o sistema deve verificar o estado atual da avaliação e validar o texto conforme as regras vigentes do iFood. Os limites externos devem ser confirmados novamente durante o desenho da integração.

## Regras pendentes

- Canal usado para entregar notificações e estado inicial da configuração.
- Estados internos da interação e quais falhas aceitam nova tentativa.
- Provedor, contexto, limites e comportamento de falha da sugestão por IA.
