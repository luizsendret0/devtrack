# Requisitos não funcionais (RNF) — DevTrack

**Requisito não funcional:** define qualidades, restrições técnicas ou padrões que o sistema deve respeitar.

| ID | Categoria | Versão | Requisito / forma de verificar |
| --- | --- | --- | --- |
| RNF-01 | Segurança | MVP | Senhas devem ser armazenadas por `password_hash()` e verificadas por `password_verify()`; nunca em texto puro. |
| RNF-02 | Segurança | MVP | Acesso ao banco deve usar PDO com consultas preparadas para entradas variáveis. |
| RNF-03 | Segurança | MVP | Formulários que alteram dados devem validar token CSRF no servidor. |
| RNF-04 | Segurança | MVP | Rotas e operações em registros devem verificar sessão e propriedade do recurso no servidor. |
| RNF-05 | Segurança | MVP | Após login, regenerar o ID de sessão; usar cookies HttpOnly e SameSite, e Secure quando houver HTTPS. |
| RNF-06 | Privacidade | MVP | Credenciais e segredos não podem ser enviados para o GitHub; configurar `.gitignore` e usar variáveis de ambiente quando aplicável. |
| RNF-07 | Usabilidade | MVP | Interface deve ser navegável em desktop e celular, inclusive a partir de 360 px de largura sem cortes de ações essenciais. |
| RNF-08 | Acessibilidade | MVP | Botões e links devem funcionar por teclado; formulários devem ter rótulos e mensagens de erro identificáveis. |
| RNF-09 | Compatibilidade | MVP | Aplicação deve funcionar em versões atuais de Chrome, Edge e Firefox; validar manualmente os fluxos principais. |
| RNF-10 | Manutenibilidade | MVP | Organizar responsabilidades em controllers, models, views e configurações, sem colocar consultas SQL diretamente nas views. |
| RNF-11 | Consistência | MVP | Dados exibidos como resultados reais devem vir do banco; valores de demonstração devem ser claramente identificados. |
| RNF-12 | Testabilidade | MVP | Manter testes ou roteiro de testes para cadastro, login, permissão por usuário e CRUD de candidaturas. |
| RNF-13 | Desempenho | Meta futura | Buscar carregamento das telas principais em até 2 segundos em ambiente de teste definido, com até 1.000 candidaturas por usuário; medir antes de afirmar que a meta foi alcançada. |
| RNF-14 | Implantação | Deploy | Em produção, utilizar HTTPS, mensagens de erro genéricas e configuração segura de sessão e banco. |

## Observação

Os itens de desempenho são **metas a medir**, não resultados já comprovados. A escolha de PHP puro implica implementar manualmente várias proteções que frameworks costumam fornecer.
