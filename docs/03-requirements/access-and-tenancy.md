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

1. O usuário informa os dados mínimos da conta, incluindo e-mail e senha, e o nome da organização.
2. O Comentaro cria o usuário e sua organização vinculada na mesma operação.
3. O sistema envia uma mensagem para confirmação do endereço de e-mail.
4. Depois de confirmar o e-mail e entrar, o usuário cadastra o primeiro estabelecimento.
5. O usuário conecta o estabelecimento ao iFood.

## Autenticação e recuperação

- A entrada usa e-mail e senha.
- O endereço de e-mail precisa ser confirmado antes do uso normal da aplicação.
- A sessão permanece válida entre acessos conforme duração a ser definida na arquitetura.
- O usuário pode encerrar a sessão explicitamente.
- A recuperação de senha começa pelo e-mail cadastrado e utiliza um mecanismo temporário de redefinição.
- Mensagens de cadastro e recuperação não devem revelar se uma conta alheia existe além do necessário para o fluxo.

Provedor, política de senha, duração da sessão e formato dos mecanismos temporários serão definidos na arquitetura.

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
