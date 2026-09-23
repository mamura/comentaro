# Módulo Connections

## Responsabilidade

O módulo `Connections` isola o domínio central das diferenças entre provedores externos. Ele gerencia `Integration`, `ExternalAccount`, capacidades declaradas, estado da conexão, saúde e progresso de sincronização.

Cada provedor possui um conector próprio:

```text
Connections
├── IFoodConnector
├── AiqfomeConnector       # futuro
└── InstagramConnector     # futuro
```

## Capacidades

Um conector pode oferecer:

- descobrir contas ou estabelecimentos autorizados;
- verificar autorização e saúde;
- capturar interações;
- consultar detalhes de uma interação;
- publicar uma resposta;
- desconectar ou reconhecer revogação.

As capacidades são explícitas. O domínio não deve presumir que todo provedor suporta resposta, sincronização incremental ou os mesmos tipos de interação.

## Limite do adaptador

O conector traduz objetos e erros externos para conceitos internos. Tipos, estados, URLs e formatos específicos do iFood permanecem dentro do adaptador iFood, exceto identificadores externos que precisem ser persistidos.

Chamadas do produto usam operações do módulo, e não clientes HTTP específicos do provedor.

## Autenticação do iFood

O Comentaro é uma aplicação centralizada SaaS e usa o fluxo `client_credentials` do iFood. `clientId`, `clientSecret` e token de acesso são credenciais da aplicação Comentaro, armazenadas somente no servidor.

O token pode conter permissões para várias lojas. Por isso, ele não deve ser armazenado como credencial de uma organização. O isolamento ocorre pela associação validada entre `Organization`, `Location`, `Integration` e `merchantId`.

O gerenciador de token deve:

- solicitar token somente no servidor;
- renovar conforme o `expiresIn` retornado, sem duração fixa presumida;
- obter novo token quando novas permissões forem propagadas;
- tratar `401` com renovação controlada;
- não repetir indefinidamente chamadas com `403`;
- nunca registrar segredo ou token em logs.

## Autorização da loja

Para aplicação centralizada, o acesso à loja é solicitado no Portal do Desenvolvedor por ID ou CNPJ. O responsável aprova no Portal do Parceiro. Depois, o Comentaro gera novo token e usa a Merchant API para confirmar se a loja aparece entre as autorizadas.

A etapa depende de operação externa e não deve ser representada como OAuth concluído instantaneamente dentro da interface do Comentaro.

## Segurança e isolamento

- Nenhum token ou segredo chega ao navegador.
- Toda operação com `merchantId` valida a associação com a organização autenticada.
- Dados de uma loja nunca são retornados a outra organização apenas porque compartilham o token do aplicativo.
- Falhas e revogações são tratadas por integração, sem interromper outras lojas.
- Logs técnicos podem registrar provedor, operação, `merchantId` e resultado, mas não credenciais nem conteúdo sensível desnecessário.

## Fontes oficiais

Verificado em 23 de setembro de 2026:

- [Criar uma aplicação iFood](https://developer.ifood.com.br/en-US/docs/getting-started/first-steps/create-app)
- [Autenticação de aplicações centralizadas](https://developer.ifood.com.br/en-US/docs/food/guides/modules/authentication/centralized)
- [Solicitar acesso a uma loja](https://developer.ifood.com.br/en-US/docs/getting-started/first-steps/request-access)
- [Introdução à autenticação](https://developer.ifood.com.br/en-US/docs/food/guides/modules/authentication/intro)
- [Merchant API](https://developer.ifood.com.br/pt-BR/docs/guides/modules/merchant/introducao/)

## Pendente

- Janela e frequência da sincronização de avaliações.
- Estratégia de paginação e checkpoint da Review API.
- Política de retentativa por classe de erro.
- Procedimento operacional exato para transições que dependem do Portal do Desenvolvedor.
