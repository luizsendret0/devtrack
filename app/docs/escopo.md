# Escopo do projeto — DevTrack

## Problema

Pessoas iniciantes em tecnologia costumam acompanhar vagas em diferentes plataformas, perder o histórico dos processos seletivos e não ter uma visão clara das tecnologias mais requisitadas nas oportunidades de seu interesse.

## Objetivo

Centralizar candidaturas e, em uma etapa posterior, recomendar prioridades de aprendizado a partir das tecnologias exigidas pelas vagas cadastradas pelo próprio usuário.

## Público-alvo

Estudantes de tecnologia, pessoas buscando o primeiro estágio ou emprego na área e desenvolvedores juniores.

## MVP — versão 1.0

1. Cadastro, login e logout.
2. Sessões e proteção de páginas restritas.
3. Cadastro, listagem, visualização, edição e exclusão de candidaturas.
4. Mudança manual de status de uma candidatura.
5. Filtros e busca de candidaturas do usuário autenticado.
6. Dashboard com contagem real por status.
7. Interface responsiva e temas claro/escuro com preferência local.

**Critério para concluir o MVP:** um usuário consegue criar conta, entrar, cadastrar uma vaga, alterar sua etapa, consultar os totais, sair e voltar sem perder os dados; outro usuário não consegue visualizar nem alterar essa vaga.

## Versão 1.1 — análise e estudos

1. Catálogo de tecnologias e associação com candidaturas.
2. Perfil de habilidades técnicas do usuário.
3. Ranking de tecnologias requisitadas nas vagas cadastradas.
4. Área de Estudos com sugestões baseadas nas lacunas identificadas.
5. Histórico de alterações de status.
6. Exportação de candidaturas em CSV.

## Versão 2 — evolução opcional

1. Trilhas e conteúdos de estudo com progresso.
2. Exercícios práticos vinculados às tecnologias.
3. Lembretes de entrevistas e prazos.
4. API REST documentada.
5. Importação assistida de informações de vagas, respeitando os termos das plataformas.

## Fora do escopo do MVP

- Coleta automática de vagas em sites de terceiros.
- Integração com contas do LinkedIn ou Gupy.
- Aplicativo mobile nativo.
- Pagamentos e assinaturas.
- Algoritmos de IA obrigatórios.

## Princípios de produto

- Dados exibidos como reais devem vir do banco, não de arrays de demonstração.
- Não prometer aprovação nem emprego.
- Priorizar privacidade e controle das informações pelo próprio usuário.
- As recomendações de estudo são indicativas, não garantias de contratação.
