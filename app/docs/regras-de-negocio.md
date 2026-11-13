# Regras de negócio (RN) — DevTrack

**Regra de negócio:** restrição e comportamento específico do domínio de candidaturas e planejamento profissional.

| ID | Versão | Regra |
| --- | --- | --- |
| RN-01 | MVP | Cada e-mail pode pertencer a somente uma conta; o sistema compara e-mails de forma consistente após normalização básica. |
| RN-02 | MVP | Uma candidatura pertence a exatamente um usuário. Somente o proprietário pode consultá-la, editá-la ou excluí-la. |
| RN-03 | MVP | Empresa e cargo são obrigatórios ao cadastrar uma candidatura. |
| RN-04 | MVP | Status permitidos: `salva`, `aplicada`, `entrevista`, `oferta`, `recusada` e `desistida`. Os quatro primeiros aparecem como colunas principais; os demais ficam em filtros/histórico. |
| RN-05 | MVP | Toda nova candidatura começa como `salva`, a menos que o usuário informe explicitamente outro status válido. |
| RN-06 | MVP | O usuário pode mudar manualmente entre os status válidos; o sistema não presume que uma entrevista ou oferta aconteceu automaticamente. |
| RN-07 | MVP | A data de envio é opcional para vagas `salva`; ao marcar como `aplicada`, `entrevista` ou `oferta`, pedir uma data de candidatura quando ela ainda não existir. |
| RN-08 | MVP | Salário e URL da vaga são opcionais; salários informados não podem ser negativos. |
| RN-09 | MVP | Ao detectar mesma URL cadastrada pelo mesmo usuário, emitir aviso de possível duplicidade, sem bloquear automaticamente. |
| RN-10 | MVP | Indicadores devem contabilizar apenas registros do usuário autenticado, seguindo a definição explícita de cada status. |
| RN-11 | V1.1 | Uma mesma tecnologia não pode aparecer mais de uma vez na mesma candidatura. |
| RN-12 | V1.1 | A frequência de uma tecnologia é o número de vagas com essa tecnologia dividido pelo número de vagas com tecnologias informadas; exibir o denominador e o período/filtro considerado. |
| RN-13 | V1.1 | Recomendações de estudo usam tecnologias exigidas e nível informado pelo usuário; se não houver dados suficientes, mostrar mensagem de orientação em vez de percentuais inventados. |
| RN-14 | V1.1 | Trilhas ou níveis de aprendizado não equivalem automaticamente a certificações profissionais. |
| RN-15 | V1.1 | Toda mudança de status deve gerar evento histórico, com status anterior, novo status e data/hora. |

## Cenários de exemplo

### RN-02: isolamento entre usuários

- Usuário A cadastra uma vaga.
- Usuário B tenta abrir a URL dessa vaga por ID.
- **Esperado:** sistema nega acesso sem revelar dados da vaga.

### RN-09: possível duplicidade

- Usuário cadastra uma vaga e depois tenta salvar a mesma URL.
- **Esperado:** sistema apresenta um aviso e permite revisão antes de confirmar.

### RN-13: ausência de dados para estudo

- Usuário ainda não adicionou tecnologias às suas vagas.
- **Esperado:** área de estudos convida a informar tecnologias, sem apresentar análise como se fosse real.
