# Interface web do Comentaro

Frontend independente em React, TypeScript e Vite. O acesso à API usa tipos gerados a partir do contrato OpenAPI compartilhado.

## Requisitos locais

O fluxo recomendado usa Docker Compose a partir da raiz do repositório. Para executar diretamente no WSL, use a versão indicada em `.nvmrc`.

## Comandos

```bash
npm install
npm run dev
npm run check
npm test
npm run build
```

Para validar o contrato e atualizar os tipos da API:

```bash
npm run api:lint
npm run api:generate
```

O endereço da API é configurado por `VITE_API_URL`.
