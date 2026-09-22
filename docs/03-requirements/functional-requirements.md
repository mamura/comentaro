# Requisitos funcionais iniciais

- **RF-001:** cadastrar um usuário junto com sua organização.
- **RF-002:** autenticar o usuário, encerrar sua sessão e permitir recuperação de acesso.
- **RF-003:** limitar todo acesso autenticado aos dados da organização vinculada ao usuário.
- **RF-004:** cadastrar e consultar estabelecimentos da organização.
- **RF-005:** conectar um estabelecimento ao iFood mediante autorização compatível com o canal.
- **RF-006:** capturar e persistir avaliações de estabelecimentos conectados sem duplicidade.
- **RF-007:** atribuir prioridade pela nota segundo as faixas aprovadas.
- **RF-008:** inferir satisfação e confiança a partir do comentário, sem alterar nota ou prioridade.
- **RF-009:** apresentar caixa de entrada e detalhe com origem, nota, comentário, prioridade, satisfação, confiança e estados.
- **RF-010:** permitir configurar notificações do estabelecimento como ativas ou silenciadas.
- **RF-011:** enviar e-mail ao usuário para cada nova avaliação quando a configuração estiver ativa.
- **RF-012:** permitir reenvio manual de notificação que falhou.
- **RF-013:** permitir ao usuário criar, editar e enviar uma resposta ao iFood quando o canal permitir.
- **RF-014:** validar o estado atual da avaliação e as restrições do texto antes do envio.
- **RF-015:** reconciliar com o iFood o resultado de um envio incerto antes de permitir nova tentativa.
- **RF-016:** registrar no histórico as tentativas e seus resultados conhecidos.
- **RF-017:** exibir falhas e permitir nova tentativa segura quando aplicável.
- **RF-018:** gerar sugestão de resposta por IA sob solicitação do usuário.
- **RF-019:** permitir revisar e editar a sugestão antes de qualquer envio.
- **RF-020:** manter a resposta manual disponível quando análise, notificação ou geração por IA falhar.

Critérios detalhados de aceite serão escritos antes da implementação de cada requisito.
