# Requisitos funcionais iniciais

- **RF-001:** cadastrar um usuário com e-mail e senha junto com sua organização.
- **RF-002:** enviar e validar a confirmação do endereço de e-mail.
- **RF-003:** autenticar o usuário com e-mail e senha.
- **RF-004:** manter a sessão entre acessos e permitir encerrá-la explicitamente.
- **RF-005:** permitir solicitar e concluir a recuperação da senha por e-mail.
- **RF-006:** limitar todo acesso autenticado aos dados da organização vinculada ao usuário.
- **RF-007:** cadastrar e consultar estabelecimentos da organização.
- **RF-008:** iniciar uma conexão do estabelecimento com o iFood por ID ou CNPJ da loja.
- **RF-009:** apresentar o estado e as orientações do processo de autorização externa.
- **RF-010:** verificar as lojas autorizadas e associar o `merchantId` confirmado ao estabelecimento correto.
- **RF-011:** importar até 100 avaliações mais recentes dos 30 dias anteriores durante a ativação.
- **RF-012:** concluir a carga inicial sem enviar notificações pelas avaliações históricas.
- **RF-013:** configurar a frequência de sincronização por integração, com padrão de uma hora.
- **RF-014:** apresentar última sincronização, resultado e próxima execução prevista.
- **RF-015:** detectar perda ou revogação da autorização sem afetar outras conexões.
- **RF-016:** desconectar um estabelecimento sem apagar as interações já capturadas.
- **RF-017:** capturar e persistir avaliações de estabelecimentos conectados sem duplicidade.
- **RF-018:** retomar sincronização falha a partir de progresso confirmado.
- **RF-019:** atribuir prioridade pela nota segundo as faixas aprovadas.
- **RF-020:** inferir satisfação e confiança a partir do comentário, sem alterar nota ou prioridade.
- **RF-021:** apresentar caixa de entrada e detalhe com origem, nota, comentário, prioridade, satisfação, confiança e estados.
- **RF-022:** permitir configurar notificações do estabelecimento como ativas ou silenciadas.
- **RF-023:** enviar e-mail ao usuário para cada nova avaliação quando a configuração estiver ativa.
- **RF-024:** permitir reenvio manual de notificação que falhou.
- **RF-025:** permitir ao usuário criar, editar e enviar uma resposta ao iFood quando o canal permitir.
- **RF-026:** validar o estado atual da avaliação e as restrições do texto antes do envio.
- **RF-027:** reconciliar com o iFood o resultado de um envio incerto antes de permitir nova tentativa.
- **RF-028:** registrar no histórico as tentativas e seus resultados conhecidos.
- **RF-029:** exibir falhas e permitir nova tentativa segura quando aplicável.
- **RF-030:** gerar sugestão de resposta por IA sob solicitação do usuário.
- **RF-031:** permitir revisar e editar a sugestão antes de qualquer envio.
- **RF-032:** manter a resposta manual disponível quando análise, notificação ou geração por IA falhar.

Os critérios detalhados estão em [acceptance-criteria.md](acceptance-criteria.md).
