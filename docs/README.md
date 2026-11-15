# Documentação técnica — DevTrack

**Versão de referência:** `v0.2.1-alpha`  
**Situação:** Landing page pública e protótipo visual do dashboard; autenticação ainda não implementada.  
**Stack:** PHP puro, HTML, CSS, JavaScript e MySQL (integração em desenvolvimento), utilizando Laragon.

O DevTrack busca organizar candidaturas a vagas de tecnologia e, em uma etapa posterior, orientar o aprendizado a partir das tecnologias exigidas nas oportunidades salvas pelo usuário.

[Voltar ao README principal](../README.md)

## Índice da documentação

| Documento | Finalidade |
| --- | --- |
| [Escopo do projeto](./escopo.md) | Problema, público-alvo, MVP e funcionalidades futuras |
| [Requisitos funcionais (RF)](./requisitos-funcionais.md) | Funcionalidades e critérios de aceitação planejados |
| [Requisitos não funcionais (RNF)](./requisitos-nao-funcionais.md) | Segurança, usabilidade, responsividade e manutenção |
| [Regras de negócio (RN)](./regras-de-negocio.md) | Restrições de contas, candidaturas e indicadores |
| [Modelo de dados](./modelo-de-dados.md) | Tabelas, campos e relacionamentos planejados |
| [Landing Page](./landing-page.md) | Objetivo, requisitos e critérios de aceite da página pública |

## Estado atual da implementação

### Implementado na interface

- Landing page pública com apresentação do produto, benefícios, demonstração e chamadas para ação.
- Navegação entre seções e menu responsivo para celular.
- Dashboard visual com sidebar, indicadores e Kanban de candidaturas fictícias.
- Prévia visual da Área de Estudos e das trilhas.
- Modos claro e escuro, preferência local do tema e efeitos Glassmorphism.
- Páginas temporárias nas seções ainda não desenvolvidas.

### Ainda não implementado

- Cadastro e autenticação reais de usuários, sessões e logout.
- Proteção do dashboard e das demais páginas privadas.
- Persistência das candidaturas no MySQL e gerenciamento CRUD completo.
- Indicadores e filtros alimentados por dados reais.
- Análise de tecnologias e recomendações individualizadas de estudo.

> **Observação:** os valores exibidos no dashboard e na Área de Estudos são dados demonstrativos. A existência de rotas de login ou cadastro **não equivale** à implementação de autenticação.

## Fluxo de navegação planejado

```text
Landing page pública (/)
   ├── Login (?page=login) ---------┐
   └── Registro (?page=register) ---┤
                                     ↓
                         Dashboard autenticado
                            ├── Candidaturas
                            └── Área de Estudos
```

A landing page deve continuar pública inclusive para pessoas autenticadas. Ter um cadastro não é o mesmo que estar logado: o acesso ao dashboard dependerá de uma sessão válida quando a autenticação for implementada.

## Convenções

| Identificador | Significado |
| --- | --- |
| `RF-XX` | Requisito funcional |
| `RNF-XX` | Requisito não funcional |
| `RN-XX` | Regra de negócio |
| `RF-LP-XX` | Requisito funcional específico da landing page |
| `RNF-LP-XX` | Requisito não funcional da landing page |
| `RN-LP-XX` | Regra de negócio da landing page |

Os documentos de escopo distinguem **MVP**, **V1.1** e **V2**. Requisitos planejados não devem ser marcados como implementados antes de concluídos e testados.

## Roadmap técnico

| Versão | Entrega | Situação |
| --- | --- | --- |
| `v0.2.1-alpha` | Landing page e protótipo visual | Atual |
| `v0.3.0-alpha` | Cadastro, login, logout, sessões e proteção de rotas | Próxima |
| `v0.4.0-alpha` | CRUD de candidaturas com autorização por proprietário | Planejada |
| `v0.5.0-beta` | Dashboard, filtros e Kanban com dados reais | Planejada |
| `v0.6.0-beta` | Testes, acessibilidade e estabilização | Planejada |
| `v1.0.0` | MVP de acompanhamento de candidaturas | Objetivo |
| `v1.1` | Análise de tecnologias e estudos recomendados | Futuro |

## Processo de atualização

1. Identificar os RF, RNF e RN associados à funcionalidade antes de programar.
2. Implementar e testar o fluxo, inclusive validações de segurança.
3. Atualizar o documento técnico correspondente.
4. Atualizar o `README.md` principal e o histórico de versões, quando existir.
5. Fazer um commit com mensagem descritiva.

**Próxima tarefa técnica:** implementar a autenticação `v0.3.0-alpha`, mantendo a landing pública e tornando o dashboard uma área privada.
