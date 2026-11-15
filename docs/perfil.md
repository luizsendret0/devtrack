# Perfil do usuário — v0.3.1-alpha

## Objetivo
Substituir o avatar estático no cabeçalho por um menu com duas opções: **Alterar foto de perfil** e **Encerrar sessão**.

## Requisitos funcionais
- RF-PER-01: Abrir/fechar o menu pelo avatar.
- RF-PER-02: Permitir upload de foto JPG/PNG/WebP de até 2 MB.
- RF-PER-03: Salvar o caminho da foto na tabela `users` para recuperá-la nas próximas sessões.
- RF-PER-04: Continuar permitindo logout via POST e token CSRF.

## Regras de negócio
- RN-PER-01: Apenas usuários autenticados podem alterar a foto.
- RN-PER-02: A foto é vinculada somente à conta autenticada (`$_SESSION['user_id']`).
- RN-PER-03: Apenas JPG/PNG/WebP validados são aceitos; SVG e arquivos executáveis são recusados.
- RN-PER-04: Imagens acima de 2 MB ou 6000 px por dimensão são recusadas.
- RN-PER-05: Ao substituir a imagem, a foto antiga gerada pelo sistema pode ser apagada.

## Requisitos não funcionais
- RNF-PER-01: O menu deve funcionar em temas claro/escuro e no celular.
- RNF-PER-02: O menu fecha ao clicar fora ou apertar Escape.
- RNF-PER-03: A senha e a sessão permanecem protegidas; o upload exige token CSRF.
- RNF-PER-04: As fotos são armazenadas com nome aleatório, sem extensões executáveis.

## Observações
- Fotos em `public/uploads/avatars` podem ser acessadas diretamente por URL. Não envie imagens privadas.
- O menu só deve ser incluído em views autenticadas.
- Esta etapa é independente da futura tela completa de perfil.
