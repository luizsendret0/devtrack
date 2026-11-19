# Kanban Interativo — DevTrack v0.5.1-beta

## Objetivo

Permitir movimentar candidaturas entre as etapas do processo seletivo diretamente no dashboard, por drag-and-drop ou seleção manual, persistindo as alterações no MySQL.

## Requisitos funcionais

- RF-K01: usuário autenticado pode arrastar uma candidatura para uma etapa do Kanban.
- RF-K02: mudanças são persistidas automaticamente, sem precisar abrir a página de detalhes.
- RF-K03: usuário pode usar "Alterar etapa" como alternativa ao arrastar.
- RF-K04: a etapa "Encerradas" permite distinguir `recusado` de `desistiu`.
- RF-K05: após atualização, cartões e contadores do dashboard refletem os dados do banco.
- RF-K06: falha no servidor não deve indicar uma mudança bem-sucedida.

## Regras de negócio

- RN-K01: cada candidatura pertence a um usuário e só ele pode modificar seu status.
- RN-K02: são permitidos os status `salva`, `candidatado`, `entrevista`, `aprovado`, `recusado` e `desistiu`.
- RN-K03: "Encerradas" é um agrupamento visual; não é um valor de status armazenado na tabela.
- RN-K04: ao passar para `candidatado`, o model existente registra a data da candidatura se estiver vazia.
- RN-K05: o endpoint exige POST, sessão autenticada e token CSRF válido.

## Arquitetura

Dashboard (PHP) -> `kanban-dnd.js` -> `POST ?page=jobs&action=status-ajax&id=...` -> `JobController` -> `Job::updateStatus()` -> MySQL -> JSON -> atualização do dashboard.

## Aceite

- Drag Salvas → Candidatadas → Entrevistas → Aprovadas funciona.
- Encerradas pergunta por Recusada ou Desisti da vaga.
- Mudanças persistem após recarregar.
- Funciona nos temas claro e escuro.
- Existe alternativa sem arrastar.
- O usuário não consegue alterar uma vaga pertencente a outro usuário.
