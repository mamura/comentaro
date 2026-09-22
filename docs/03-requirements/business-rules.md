# Regras de negócio iniciais

## Regras aceitas

### RN-001 — Origem da interação

No primeiro recorte, uma interação é uma avaliação do iFood vinculada a um estabelecimento conectado.

### RN-002 — Prioridade

A nota da avaliação é o sinal principal da prioridade. O mapeamento exato entre nota e nível de prioridade ainda precisa ser aprovado.

### RN-003 — Satisfação inferida

O texto do comentário pode ser usado para inferir um nível de satisfação. Esse resultado deve permanecer separado da prioridade e da nota original, que não podem ser sobrescritas pela inferência.

### RN-004 — Casos críticos

O MVP não classifica casos críticos nem cria um fluxo especial para eles. Essa regra só será definida depois da análise de exemplos reais.

### RN-005 — Destinatário da notificação

A notificação é destinada ao responsável pelo estabelecimento ao qual a avaliação pertence.

### RN-006 — Responsável pela resposta

O mesmo perfil responsável pelo estabelecimento prepara e envia a resposta.

### RN-007 — Falha visível

Uma falha deve deixar visível o estado atual da interação e ser registrada no histórico com a etapa afetada e o resultado conhecido.

### RN-008 — Nova tentativa segura

Quando uma operação puder ser repetida, a nova tentativa não deve duplicar a avaliação, a notificação ou a resposta. O resultado de cada tentativa deve integrar o histórico.

### RN-009 — Restrição de resposta do iFood

Antes de oferecer ou executar o envio, o sistema deve verificar o estado atual da avaliação e validar o texto conforme as regras vigentes do iFood. Os limites externos devem ser confirmados novamente durante o desenho da integração.

## Regras pendentes

- Faixas de nota para cada prioridade.
- Escala e confiança da satisfação inferida.
- Eventos que disparam notificação, canal utilizado e prazo esperado.
- Estados internos da interação e quais falhas aceitam nova tentativa.
- Uso e aprovação de sugestões de resposta por IA.
