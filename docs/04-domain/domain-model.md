# Modelo de domínio conceitual

```text
Organization
└── Location
    └── Integration
        └── Interaction
```

- **Organization:** negócio acompanhado pelo Comentaro.
- **Location:** unidade ou estabelecimento da organização, sem pressupor restaurante.
- **Integration:** vínculo autorizado entre uma unidade e um canal externo.
- **Interaction:** item recebido de um canal conectado que pode ser analisado, priorizado e respondido conforme a capacidade do canal. É o conceito central do domínio.

`Interaction` pode abranger avaliações e outros formatos de interação; os tipos suportados serão definidos após validar os provedores. Resposta, análise e notificação são conceitos do fluxo, mas seus atributos e relacionamentos ainda não foram fechados.

O modelo representa relações conceituais, não tabelas, cardinalidades, APIs ou uma arquitetura implementada.
