# Jornadas iniciais

## 1. Configurar o acompanhamento

Um responsável identifica sua `Organization` e `Location`, conecta a integração do iFood e passa a acompanhar as avaliações associadas ao estabelecimento. Ele pode manter as notificações ativas ou silenciá-las. O número de unidades disponível no MVP ainda precisa ser definido.

## 2. Capturar e analisar uma avaliação

O Comentaro captura uma avaliação do estabelecimento conectado, evita duplicidade e registra conteúdo, nota, origem e horários relevantes. A nota determina a prioridade: 1–2 alta, 3 média e 4–5 baixa.

O texto é analisado separadamente para inferir satisfação e confiança. A satisfação pode ser muito insatisfeito, insatisfeito, neutro, satisfeito, muito satisfeito ou indeterminado. O MVP não tenta identificar casos críticos.

## 3. Notificar o responsável

Se as notificações do estabelecimento estiverem ativas, cada nova avaliação gera aviso para o responsável. Se estiverem silenciadas, a avaliação permanece disponível na caixa de entrada, sem aviso externo. O canal de entrega ainda precisa ser definido.

## 4. Preparar e enviar a resposta

O responsável abre a interação, examina conteúdo, nota, satisfação inferida, confiança, prioridade e histórico. Ele pode redigir a resposta ou solicitar uma sugestão por IA, revisar e editar o texto e confirmar o envio ao iFood. A sugestão por IA tem menor prioridade de implementação que o fluxo principal e nunca é publicada automaticamente.

Antes do envio, o sistema deve verificar se a avaliação ainda aceita resposta e se o texto cumpre as regras do iFood. O resultado do envio atualiza o estado e o histórico da interação.

## 5. Recuperar uma falha

Se captura, análise, notificação, geração da sugestão ou envio falhar, o Comentaro mostra o estado da interação e registra a ocorrência. Quando a operação puder ser repetida, oferece uma nova tentativa segura, sem duplicar avaliações, notificações ou respostas.

## Fluxo resumido

`captura → análise → prioridade e satisfação → notificação opcional → resposta → histórico`
