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

1. O usuário informa nome, e-mail, senha, confirmação da senha e nome da organização.
2. Quando aplicável, o usuário aceita os termos apresentados.
3. O Comentaro cria o usuário e sua organização vinculada na mesma transação.
4. O sistema envia uma mensagem para confirmação do endereço de e-mail.
5. O usuário pode entrar antes de confirmar o e-mail, mas as funcionalidades internas permanecem bloqueadas.
6. Depois de confirmar o e-mail, o usuário cadastra o primeiro estabelecimento e inicia sua conexão com o iFood.

Se a criação do usuário ou da organização falhar, a operação inteira deve ser desfeita.

## Política de senha

- A senha deve ter no mínimo 10 caracteres.
- O cadastro exige confirmação da senha.
- O MVP não exige combinações específicas de letras maiúsculas, minúsculas, números e símbolos.
- O backend armazena apenas o hash seguro da senha.
- Login, confirmação e recuperação possuem limites de tentativas.

## Confirmação de e-mail

- O link de confirmação é válido por 60 minutos e pode ser usado uma única vez.
- O usuário pode solicitar um novo envio.
- O reenvio possui limitação de frequência.
- A confirmação anterior perde efeito quando o endereço de e-mail for alterado.
- As respostas públicas não devem revelar indevidamente se uma conta existe.

## Sessão

- A autenticação da SPA usa Laravel Sanctum com sessão em cookie.
- A sessão comum expira depois de duas horas de inatividade.
- A opção “Manter conectado” estende o acesso por até 30 dias.
- O logout encerra a sessão atual.
- A alteração de senha encerra as demais sessões.
- Cookies de produção devem usar `HttpOnly`, `Secure` e uma política `SameSite` compatível com a implantação.
- A proteção CSRF é obrigatória.
- O frontend nunca armazena a credencial de sessão em `localStorage`.

## Recuperação de senha

- A solicitação começa pelo e-mail cadastrado.
- A resposta pública é neutra e não confirma se o endereço possui conta.
- O link temporário é válido por 60 minutos e pode ser usado uma única vez.
- Solicitações possuem limitação de frequência.
- A redefinição bem-sucedida encerra as demais sessões.

## Isolamento por organização

- O backend obtém a organização a partir do usuário autenticado.
- O cliente não escolhe o escopo de acesso enviando uma `organization_id`.
- Recursos pertencentes ao cliente carregam ou derivam sua organização.
- Consultas, comandos, jobs e políticas de autorização validam esse limite.
- Testes devem tentar acessar recursos de outra organização e comprovar a rejeição.
- Ocultar uma ação no frontend não substitui a autorização no backend.

## Fora do MVP

- autenticação social;
- segundo fator de autenticação;
- múltiplos usuários por organização;
- convites;
- papéis e permissões;
- usuário associado a mais de uma organização;
- administração de planos e cobrança.

Aplicativos móveis poderão usar tokens de API do Sanctum. OAuth2 com Laravel Passport será avaliado apenas se o Comentaro precisar autorizar aplicações de terceiros.
