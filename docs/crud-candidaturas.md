# DevTrack — Cadastro e gerenciamento de candidaturas (v0.4.0-alpha)

**Situação:** implementação disponibilizada; verificar no Laragon e no MySQL local antes de marcar como concluída.

## Objetivo

Permitir que cada usuário autenticado registre oportunidades de emprego/estágio e acompanhe o status do próprio processo seletivo.

## Escopo desta etapa

- Criar uma candidatura com empresa e cargo obrigatórios.
- Armazenar modalidade, tipo, localização, salário, link, status, data e observações (opcionais).
- Listar e pesquisar as próprias candidaturas por empresa/cargo; filtrar por status.
- Visualizar detalhes, editar, alterar status e excluir com confirmação no navegador.
- Impedir que uma conta consulte, edite ou exclua uma candidatura de outra conta.
- Utilizar validação no servidor, consultas parametrizadas com PDO e CSRF em todas as ações de escrita.

## Requisitos funcionais

- **RF-J01:** Permitir cadastrar candidaturas.
- **RF-J02:** Listar as candidaturas do usuário autenticado.
- **RF-J03:** Permitir pesquisar por empresa/cargo e filtrar por status.
- **RF-J04:** Permitir consultar detalhes e editar candidaturas próprias.
- **RF-J05:** Permitir alterar o status de candidaturas próprias.
- **RF-J06:** Permitir excluir candidaturas próprias.

## Regras de negócio

- **RN-J01:** Cada candidatura possui exatamente um usuário proprietário (`user_id`).
- **RN-J02:** Empresa e cargo são obrigatórios, limitados a 150 caracteres.
- **RN-J03:** O status pertence a: salva, candidatado, entrevista, aprovado, recusado ou desistiu.
- **RN-J04:** Salário, quando informado, não pode ser negativo; links devem ser HTTP(S).
- **RN-J05:** Ações sobre candidatura de outro usuário retornam 404 e não alteram o banco.
- **RN-J06:** Ao marcar "candidatado" pela ação rápida de status, a data de candidatura é preenchida automaticamente somente quando estava vazia.
- **RN-J07:** Dados de candidaturas não ficam visíveis para usuários deslogados.

## Requisitos não funcionais

- **RNF-J01:** Ações de gravação exigem POST + CSRF válido.
- **RNF-J02:** Todas as consultas usam PDO parametrizado.
- **RNF-J03:** Saídas dinâmicas são escapadas para prevenir XSS.
- **RNF-J04:** A interface acompanha as variáveis dos temas claro/escuro e é responsiva.
- **RNF-J05:** Erros internos do banco não são exibidos ao usuário; detalhes vão para o log do PHP.

## Rotas

O projeto utiliza o roteador existente de `public/index.php` e a query `?page=jobs`.

| Método | URL | Descrição |
|---|---|---|
| GET | `?page=jobs` | Listagem e filtros |
| GET | `?page=jobs&action=create` | Cadastro |
| POST | `?page=jobs&action=store` | Salvar |
| GET | `?page=jobs&action=show&id=123` | Detalhes |
| GET | `?page=jobs&action=edit&id=123` | Editar |
| POST | `?page=jobs&action=update&id=123` | Atualizar |
| POST | `?page=jobs&action=status&id=123` | Alterar status |
| POST | `?page=jobs&action=delete&id=123` | Excluir |

## Critérios de aceite (executar localmente)

- [ ] Cadastrar uma candidatura, atualizar a página e vê-la persistida.
- [ ] Editar uma candidatura e ver a alteração persistida.
- [ ] Filtrar pelo status e pesquisar por empresa/cargo.
- [ ] Alterar o status em Detalhes e confirmar no banco.
- [ ] Excluir uma candidatura com confirmação e verificar que sumiu.
- [ ] Testar duas contas; dados de uma não aparecem para a outra.
- [ ] Tentar abrir `show/edit` de uma candidatura de outra conta: HTTP 404.
- [ ] Enviar POST sem CSRF: HTTP 403.
- [ ] Tentar abrir `?page=jobs` deslogado: redirecionamento para login.
- [ ] Validar modos claro/escuro e telas pequenas.

## Fora do escopo atual

- Indicadores reais e Kanban na página `dashboard` (v0.5.0-beta).
- Análise de tecnologias e trilhas de estudos (v1.1, conforme roadmap atual).
- Paginação acima de 100 resultados.
- Importação automatizada de vagas externas.
