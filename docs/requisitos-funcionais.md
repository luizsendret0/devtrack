# Requisitos funcionais (RF) — DevTrack

**Requisito funcional:** descreve uma ação ou capacidade que o sistema deve oferecer.

| ID | Prioridade | Versão | Requisito / critério de aceitação |
| --- | --- | --- | --- |
| RF-01 | Alta | MVP | Permitir cadastrar usuário com nome, e-mail e senha; rejeitar e-mail duplicado. |
| RF-02 | Alta | MVP | Permitir login com e-mail e senha; negar acesso quando inválidos. |
| RF-03 | Alta | MVP | Permitir logout e encerrar a sessão autenticada. |
| RF-04 | Alta | MVP | Exigir autenticação para acessar dashboard, vagas e demais seções privadas. |
| RF-05 | Alta | MVP | Permitir cadastrar candidatura com empresa, cargo e status; campos extras podem ser opcionais. |
| RF-06 | Alta | MVP | Listar somente as candidaturas do usuário autenticado. |
| RF-07 | Alta | MVP | Permitir visualizar e editar informações de uma candidatura própria. |
| RF-08 | Alta | MVP | Permitir excluir uma candidatura própria mediante confirmação. |
| RF-09 | Alta | MVP | Permitir alterar manualmente o status de uma candidatura própria. |
| RF-10 | Média | MVP | Filtrar candidaturas por status e pesquisar por empresa ou cargo. |
| RF-11 | Alta | MVP | Exibir no dashboard contagens reais de candidaturas por status, do usuário autenticado. |
| RF-12 | Média | MVP | Permitir alternar entre tema claro e escuro, mantendo a preferência no navegador. |
| RF-13 | Média | V1.1 | Associar uma ou mais tecnologias a cada candidatura, sem duplicidade. |
| RF-14 | Média | V1.1 | Permitir usuário cadastrar e alterar seu nível em cada tecnologia. |
| RF-15 | Média | V1.1 | Exibir frequência das tecnologias nas vagas que possuem tecnologias informadas. |
| RF-16 | Média | V1.1 | Sugerir prioridades de estudo com base em vagas cadastradas e habilidades informadas. |
| RF-17 | Baixa | V1.1 | Registrar histórico de mudanças de status com data/hora. |
| RF-18 | Baixa | V1.1 | Exportar as próprias candidaturas em arquivo CSV. |
| RF-19 | Baixa | V2 | Permitir criar e acompanhar trilhas de aprendizado. |
| RF-20 | Baixa | V2 | Apresentar conteúdos e exercícios por tecnologia. |

## Observações de implementação

- Uma interface desenhada ou um link de menu não significam que o RF esteja implementado.
- O módulo de estudos só deve mostrar recomendações calculadas após existirem tecnologias por vaga e habilidades do usuário.
- Os RF devem orientar testes e os commits das funcionalidades.

## Landing Page pública — `v0.2.1-alpha`

A landing possui requisitos funcionais próprios, detalhados em [landing-page.md](./landing-page.md), e integra o fluxo público do produto.

| ID | Requisito | Implementação |
| --- | --- | --- |
| RF-LP-01 | Exibir a landing na rota pública `/`. | Interface desenvolvida |
| RF-LP-02 | Apresentar Hero, recursos, demonstração, funcionamento e chamada final. | Interface desenvolvida |
| RF-LP-03 | Disponibilizar links de login e cadastro. | Links criados; formulários reais pendentes |
| RF-LP-04 | Oferecer acesso ao dashboard para usuário autenticado. | Condicional criada; autenticação pendente |
| RF-LP-05 | Navegação interna por âncoras. | Interface desenvolvida |
| RF-LP-06 | Alternar e persistir tema claro/escuro. | Código desenvolvido |
| RF-LP-07 | Menu mobile acessível e fechável por `Escape`. | Código desenvolvido |
| RF-LP-08 | Link para o GitHub do projeto. | Interface desenvolvida |
| RF-LP-09 | Identificar prévias e indicadores demonstrativos. | Interface desenvolvida |

A interface da landing não comprova implementação dos RF-01 a RF-04 (autenticação). Os estados só devem ser marcados como concluídos após testes.
