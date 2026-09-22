# Requisitos funcionais iniciais

- **RF-001:** cadastrar um usuário com e-mail e senha junto com sua organização.
- **RF-002:** enviar e validar a confirmação do endereço de e-mail.
- **RF-003:** autenticar o usuário com e-mail e senha.
- **RF-004:** manter a sessão entre acessos e permitir encerrá-la explicitamente.
- **RF-005:** permitir solicitar e concluir a recuperação da senha por e-mail.
- **RF-006:** limitar todo acesso autenticado aos dados da organização vinculada ao usuário.
- **RF-007:** cadastrar e consultar estabelecimentos da organização.
- **RF-008:** conectar um estabelecimento ao iFood mediante autorização compatível com o canal.
- **RF-009:** capturar e persistir avaliações de estabelecimentos conectados sem duplicidade.
- **RF-010:** atribuir prioridade pela nota segundo as faixas aprovadas.
- **RF-011:** inferir satisfação e confiança a partir do comentário, sem alterar nota ou prioridade.
- **RF-012:** apresentar caixa de entrada e detalhe com origem, nota, comentário, prioridade, satisfação, confiança e estados.
- **RF-013:** permitir configurar notificações do estabelecimento como ativas ou silenciadas.
- **RF-014:** enviar e-mail ao usuário para cada nova avaliação quando a configuração estiver ativa.
- **RF-015:** permitir reenvio manual de notificação que falhou.
- **RF-016:** permitir ao usuário criar, editar e enviar uma resposta ao iFood quando o canal permitir.
- **RF-017:** validar o estado atual da avaliação e as restrições do texto antes do envio.
- **RF-018:** reconciliar com o iFood o resultado de um envio incerto antes de permitir nova tentativa.
- **RF-019:** registrar no histórico as tentativas e seus resultados conhecidos.
- **RF-020:** exibir falhas e permitir nova tentativa segura quando aplicável.
- **RF-021:** gerar sugestão de resposta por IA sob solicitação do usuário.
- **RF-022:** permitir revisar e editar a sugestão antes de qualquer envio.
- **RF-023:** manter a resposta manual disponível quando análise, notificação ou geração por IA falhar.

Critérios detalhados de aceite serão escritos antes da implementação de cada requisito.
