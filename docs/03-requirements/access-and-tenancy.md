# Cadastro, acesso e isolamento

## MVP

- Cada conta de usuário pertence a exatamente uma `Organization`.
- Cada organização possui um único usuário no MVP.
- O usuário possui o mesmo acesso a todas as `Location`, `Integration` e `Interaction` da sua organização.
- Não existem perfis, papéis ou permissões diferenciadas.
- O usuário da organização é o responsável pelas notificações e respostas de todos os seus estabelecimentos.
- Toda consulta e alteração autenticada deve permanecer limitada à organização do usuário.
- Identificadores fornecidos pelo cliente não podem permitir acesso a dados de outra organização.

## Jornada de cadastro

1. O usuário informa os dados mínimos da conta e da organização.
2. O Comentaro cria o usuário e sua organização vinculada.
3. Depois de autenticado, o usuário cadastra o primeiro estabelecimento.
4. O usuário conecta o estabelecimento ao iFood.

Os campos exatos e o mecanismo de autenticação serão definidos com a arquitetura. O produto deve permitir entrada, saída e recuperação de acesso; o método técnico não está decidido.

## Evolução futura

Se o Comentaro se tornar um produto comercial, devem ser avaliados:

- múltiplos usuários por organização;
- convites e remoção de membros;
- papéis e permissões;
- usuário associado a mais de uma organização;
- administração da assinatura, planos e cobrança;
- suporte operacional entre organizações;
- estratégia técnica de isolamento, auditoria e migração de dados.

Essas possibilidades não autorizam implementação antecipada no MVP.
