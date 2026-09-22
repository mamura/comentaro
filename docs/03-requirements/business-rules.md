# Regras de negócio iniciais

## Regras aceitas

### RN-001 — Origem e unicidade

No primeiro recorte, uma interação é uma avaliação do iFood vinculada a um estabelecimento conectado. A identificação fornecida pelo canal deve impedir que a mesma avaliação seja cadastrada duas vezes.

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

A notificação é configurada por estabelecimento como ativa ou silenciada e começa ativa depois da conexão com o iFood.

- Ativa: cada nova avaliação capturada gera um e-mail para o responsável pelo estabelecimento.
- Silenciada: a avaliação continua sendo capturada e exibida, sem envio de e-mail.

Alterar a configuração afeta somente avaliações capturadas depois da alteração.

### RN-006 — Envio da notificação

O estado `enviada` significa que o serviço de e-mail aceitou a mensagem. Esse estado não significa que o destinatário recebeu, abriu ou leu o e-mail.

Uma notificação com falha pode ser reenviada manualmente. Uma notificação aceita pelo serviço de e-mail não deve ser reenviada pelo fluxo normal.

### RN-007 — Responsável pela resposta

O mesmo perfil responsável pelo estabelecimento prepara e envia a resposta.

### RN-008 — Sugestão de resposta por IA

O sistema pode gerar uma sugestão de resposta, que deve permanecer editável. O responsável decide se a utiliza e confirma qualquer envio. O sistema não publica automaticamente uma sugestão.

Uma falha na geração da sugestão não impede que o responsável escreva e envie uma resposta manual.

### RN-009 — Falhas independentes

Uma falha deve deixar visível o estado da etapa afetada e ser registrada no histórico. Falhar na análise de satisfação não impede a leitura ou a resposta manual. Falhar na notificação não altera o processamento nem o estado de resposta da interação.

### RN-010 — Nova tentativa segura

Quando uma operação puder ser repetida, a nova tentativa não deve duplicar avaliação, notificação ou resposta. Cada tentativa registra data, etapa, resultado conhecido e mensagem de erro disponível.

### RN-011 — Reconciliação antes de reenviar resposta

Antes de repetir um envio cujo resultado seja incerto, o Comentaro deve consultar o estado atual no iFood. Se a resposta já estiver registrada no canal, a interação deve ser reconciliada como respondida sem um novo envio.

### RN-012 — Restrição de resposta do iFood

Antes de oferecer ou executar o envio, o sistema deve verificar o estado atual da avaliação e validar o texto conforme as regras vigentes do iFood. Se o canal não aceitar mais uma resposta, o estado de resposta passa a `indisponível`.

## Regras pendentes

- Estados e expiração da autorização da integração com o iFood.
- Provedor de e-mail e tratamento de eventos posteriores à aceitação da mensagem.
- Provedor, contexto e limites da sugestão por IA.
