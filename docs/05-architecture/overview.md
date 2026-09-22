# Arquitetura — estado inicial

Ainda não há aplicação nem arquitetura técnica implementada. Esta etapa registra somente limites para as próximas decisões.

O desenho futuro deve contemplar cadastro e autenticação, isolamento por organização, captura a partir de canais conectados, normalização das interações, análise e priorização, notificação, apoio à resposta e histórico.

## Diretriz de isolamento

`Organization` é o limite de acesso aos dados desde o MVP. Toda operação autenticada deve derivar a organização do usuário autenticado e restringir consultas e alterações a ela. A estratégia técnica será definida na arquitetura.

Essa diretriz prepara a evolução para múltiplos clientes sem antecipar perfis, convites, cobrança ou outras funções comerciais.

## Decisões pendentes

- Stack, componentes, persistência e hospedagem.
- Provedor e mecanismo de autenticação e recuperação de acesso.
- Estratégia técnica de isolamento e testes contra acesso entre organizações.
- Mecanismo de coleta por canal e tratamento de falhas, duplicatas e atrasos.
- Provedores de IA e e-mail.

Decisões técnicas futuras devem ser justificadas e registradas em `adr/` antes de guiar a implementação.
