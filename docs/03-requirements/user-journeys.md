# Jornadas iniciais

## 1. Configurar o acompanhamento

Um responsável identifica sua `Organization` e `Location`, conecta a integração do iFood e passa a acompanhar as avaliações associadas ao estabelecimento. O número de unidades e integrações disponível no MVP ainda precisa ser definido.

## 2. Capturar e analisar uma avaliação

O Comentaro captura uma avaliação do estabelecimento conectado, evita duplicidade e registra conteúdo, nota, origem e horários relevantes. A nota alimenta a prioridade. O texto do comentário é analisado separadamente para inferir o nível de satisfação.

As faixas de prioridade e a escala de satisfação permanecem pendentes. O MVP não tenta identificar casos críticos enquanto não houver exemplos reais e critérios validados.

## 3. Notificar o responsável

Quando a regra de notificação for atendida, o Comentaro avisa o responsável pelo estabelecimento. O canal, o gatilho e o prazo do aviso ainda precisam ser definidos.

## 4. Preparar e enviar a resposta

O responsável abre a interação, examina conteúdo, nota, satisfação inferida, prioridade e histórico, prepara a resposta e solicita o envio ao iFood. A eventual geração de sugestão por IA permanece pendente.

Antes do envio, o sistema deve verificar se a avaliação ainda aceita resposta e se o texto cumpre as regras do iFood. O resultado do envio deve atualizar o estado e o histórico da interação.

## 5. Recuperar uma falha

Se captura, análise, notificação ou envio falhar, o Comentaro mostra o estado da interação e registra a ocorrência. Quando a operação puder ser repetida, oferece uma nova tentativa segura, sem duplicar avaliações, notificações ou respostas.

## Fluxo resumido

`captura → análise → prioridade e satisfação → notificação → resposta → histórico`
