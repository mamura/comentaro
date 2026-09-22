# Requisitos funcionais iniciais

- **RF-001:** conectar um estabelecimento ao iFood mediante autorização compatível com o canal.
- **RF-002:** capturar e persistir avaliações de estabelecimentos conectados sem duplicidade.
- **RF-003:** atribuir prioridade pela nota segundo as faixas aprovadas.
- **RF-004:** inferir satisfação e confiança a partir do comentário, sem alterar nota ou prioridade.
- **RF-005:** apresentar caixa de entrada e detalhe com origem, nota, comentário, prioridade, satisfação, confiança e estados.
- **RF-006:** permitir configurar notificações do estabelecimento como ativas ou silenciadas.
- **RF-007:** enviar e-mail ao responsável para cada nova avaliação quando a configuração estiver ativa.
- **RF-008:** permitir reenvio manual de notificação que falhou.
- **RF-009:** permitir ao responsável criar, editar e enviar uma resposta ao iFood quando o canal permitir.
- **RF-010:** validar o estado atual da avaliação e as restrições do texto antes do envio.
- **RF-011:** reconciliar com o iFood o resultado de um envio incerto antes de permitir nova tentativa.
- **RF-012:** registrar no histórico as tentativas e seus resultados conhecidos.
- **RF-013:** exibir falhas e permitir nova tentativa segura quando aplicável.
- **RF-014:** gerar sugestão de resposta por IA sob solicitação do responsável.
- **RF-015:** permitir revisar e editar a sugestão antes de qualquer envio.
- **RF-016:** manter a resposta manual disponível quando análise, notificação ou geração por IA falhar.

Critérios detalhados de aceite serão escritos antes da implementação de cada requisito.
