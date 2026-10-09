# ADR-003 — Autenticação da SPA com sessão e cookie

**Status:** Aceita
**Data:** 2026-10-09

## Contexto

O frontend React e o backend Laravel são aplicações independentes, mas pertencem ao Comentaro e serão publicados sob o mesmo domínio principal. O MVP precisa de cadastro, confirmação de e-mail, recuperação de senha, sessão persistente e encerramento imediato do acesso.

JWT foi considerado por causa da separação entre frontend e backend. Essa separação não exige tokens autossuficientes e o MVP não possui clientes independentes, arquitetura distribuída ou autorização de terceiros que justifiquem access tokens e refresh tokens.

## Decisão

Usar Laravel Sanctum para autenticar a SPA própria com a sessão do Laravel armazenada em cookie seguro. Frontend e API devem compartilhar o mesmo domínio principal, ainda que usem subdomínios diferentes.

Em produção, os cookies serão `HttpOnly` e `Secure`, com `SameSite` compatível com a topologia adotada. Requisições mutáveis terão proteção CSRF. CORS aceitará apenas origens explicitamente configuradas e requisições autenticadas enviarão credenciais.

A sessão comum expira depois de duas horas de inatividade. A opção “Manter conectado” estende o acesso por até 30 dias. Logout, troca de senha e mecanismos administrativos futuros devem permitir revogação no servidor.

A autorização e o isolamento por `Organization` permanecem no backend. O frontend não envia uma organização para determinar o próprio escopo.

## Alternativas consideradas

### JWT para a SPA

Não adotado no MVP. Exigiria definir emissão, armazenamento, access token, refresh token, rotação, detecção de reutilização e revogação. Guardá-lo em `localStorage` exporia a credencial ao JavaScript; guardá-lo em cookie manteria a necessidade de proteção CSRF sem oferecer benefício proporcional neste cenário.

### OAuth2 com Laravel Passport

Adiado. Será considerado quando aplicações de terceiros precisarem receber autorização delegada. O MVP não oferece esse recurso.

### Tokens Sanctum para todos os clientes

Não adotado para a SPA própria. Tokens pessoais continuam disponíveis futuramente para aplicativos móveis ou clientes controlados que não usem a sessão web.

## Consequências

- A API permanece separada do frontend e mantém estado de sessão revogável.
- O navegador não disponibiliza a credencial de sessão ao código React.
- A implantação deve manter frontend e API sob o mesmo domínio principal.
- Configurações de domínio de cookie, CORS, CSRF e origens confiáveis fazem parte da entrega.
- Aplicativos móveis podem receber tokens Sanctum no futuro sem alterar a autenticação da SPA.
