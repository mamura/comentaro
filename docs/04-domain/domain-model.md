# Modelo de domínio conceitual

```text
Organization
└── Location
    ├── Responsible
    └── Integration
        └── Interaction
            ├── Analysis
            ├── Notification
            ├── Reply
            └── HistoryEntry
```

- **Organization:** negócio acompanhado pelo Comentaro.
- **Location:** unidade ou estabelecimento da organização, sem pressupor restaurante.
- **Responsible:** perfil que recebe notificações e prepara e envia respostas pela unidade.
- **Integration:** vínculo autorizado entre uma unidade e um canal externo.
- **Interaction:** item recebido de um canal conectado. É o conceito central do domínio.
- **Analysis:** prioridade, satisfação inferida, confiança e estado de processamento.
- **Notification:** tentativa de avisar o responsável e seu estado.
- **Reply:** rascunho, sugestão, tentativa de envio e estado da resposta.
- **HistoryEntry:** registro temporal de eventos e tentativas relevantes.

Os estados de processamento, notificação, resposta e sugestão por IA são independentes. O modelo representa relações conceituais, não tabelas, cardinalidades, APIs ou uma arquitetura implementada.
