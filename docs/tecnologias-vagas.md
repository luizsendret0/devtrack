# DevTrack — Tecnologias nas candidaturas (v0.6.0-beta)

## O que foi entregue

- Vagas aceitam ate 15 tecnologias separadas por virgula, ponto e virgula ou quebra de linha.
- Tecnologias ficam nas tabelas `skills` e `job_skills` (relacao N:N).
- Cadastro/edicao e vinculacao de tecnologias sao atomicos (transacao PDO).
- Cada usuario so consulta as tecnologias das suas candidaturas.
- Tela de detalhes e listagem mostram tecnologias; o dashboard exibe ranking verdadeiro por frequencia nas vagas.
- Migracao repetivel `php database/upgrade-skills.php`, sem excluir registros.

## Regras

1. O texto e preenchido manualmente a partir do anuncio; nao existe extracao automatica.
2. Cada tecnologia e contada uma vez por vaga, inclusive quando repetida no formulario.
3. Tecnologias compartilhadas na tabela `skills` nao expõem candidaturas de outros usuarios.
4. Excluir uma candidatura remove suas relacoes automaticamente (`ON DELETE CASCADE`).
5. Alterar o status com drag & drop nao altera as tecnologias da vaga.
6. Apenas vagas cadastradas pelo usuario participam do ranking; inclui vagas encerradas.

## Proximas etapas

- Minha lista de habilidades, niveis e lacunas (`user_skills`).
- Priorizacao de estudo com comparacao de vagas x conhecimentos pessoais.
- Trilhas, conteudos, tarefas e progresso real.
