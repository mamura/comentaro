# Arquitetura — estado inicial

Ainda não há aplicação nem arquitetura técnica implementada. Esta etapa registra limites e decisões conceituais para o desenho posterior.

O desenho futuro deve contemplar cadastro e autenticação, isolamento por organização, conexões externas, captura e normalização de interações, análise e priorização, notificação, apoio à resposta e histórico.

## Diretriz de isolamento

`Organization` é o limite de acesso aos dados desde o MVP. Toda operação autenticada deve derivar a organização do usuário autenticado e restringir consultas e alterações a ela. A estratégia técnica será definida na arquitetura.

## Diretriz de integrações

O módulo `Connections` gerencia integrações e expõe capacidades independentes do provedor. Cada provedor possui um conector. Credenciais da aplicação e tokens permanecem no servidor; associações de contas externas pertencem às organizações e unidades autorizadas.

Consulte [integrations.md](integrations.md) para o desenho conceitual e as restrições verificadas do iFood.

## Decisões pendentes

- Stack, componentes, persistência e hospedagem.
- Provedor e mecanismo de autenticação e recuperação de acesso.
- Estratégia técnica de isolamento e testes contra acesso entre organizações.
- Frequência, checkpoint e tratamento de falhas da sincronização de avaliações.
- Provedores de IA e e-mail.

Decisões técnicas futuras devem ser justificadas e registradas em `adr/` antes de guiar a implementação.
