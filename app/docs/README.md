# DevTrack Documentation

- [Project Scope](./escopo.md)
- [Functional Requirements](./requisitos-funcionais.md)
- [Non-Functional Requirements](./requisitos-nao-funcionais.md)
- [Business Rules](./regras-de-negocio.md)
- [Data Model](./modelo-de-dados.md)

O **DevTrack** é uma aplicação web para organizar candidaturas a vagas de tecnologia e orientar estudos com base nos requisitos das oportunidades cadastradas.

## Stack definida

- Front-end: HTML, CSS e JavaScript.
- Back-end: PHP puro, com separação em controllers, models e views.
- Banco de dados: MySQL, acessado via PDO e consultas preparadas.
- Ambiente local: Laragon.
- Versionamento: Git e GitHub.

## Documentos

| Arquivo | Conteúdo |
| --- | --- |
| [escopo.md](escopo.md) | Objetivo, público-alvo, MVP e próximas versões |
| [requisitos-funcionais.md](requisitos-funcionais.md) | Funcionalidades esperadas, identificadas por RF |
| [requisitos-nao-funcionais.md](requisitos-nao-funcionais.md) | Restrições e critérios de qualidade, identificados por RNF |
| [regras-de-negocio.md](regras-de-negocio.md) | Regras e restrições do domínio, identificadas por RN |
| [modelo-de-dados.md](modelo-de-dados.md) | Entidades e relacionamentos planejados |

## Convenções

- `RF-XX`: requisito funcional.
- `RNF-XX`: requisito não funcional.
- `RN-XX`: regra de negócio.
- Os itens com **MVP** são da primeira entrega; **V1.1** e **V2** são posteriores.
- Este documento descreve **o sistema planejado**; não significa que todas as funções estejam implementadas.
- Sempre que uma regra mudar, atualize o documento correspondente **e** os testes.

## Estado do projeto ao criar esta documentação

O layout do dashboard e a alternância visual claro/escuro já foram trabalhados. A autenticação, persistência real de candidaturas, indicadores dinâmicos e recomendações de estudo ainda fazem parte do planejamento de implementação.
