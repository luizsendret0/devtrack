# DevTrack v0.4.0-alpha — Instalação do CRUD de candidaturas

Este pacote foi construído para a base **DevTrack v0.3.1-alpha em PHP puro + Laragon**, com a landing, autenticação e menu de perfil já funcionando. Ele **não inclui o repositório completo** e **não sobrescreve** `public/index.php`, layouts ou os CSS anteriores.

## 1. Salve seu trabalho

Faça um commit ou backup antes de alterar o projeto, principalmente `public/index.php` e `database/schema.sql`. Não recrie nem apague a tabela `users`.

## 2. Copie os novos arquivos

Copie as pastas `app/`, `views/`, `public/`, `database/` e `docs/` deste pacote para `C:\laragon\www\devtrack`, mantendo o caminho de cada arquivo.

- `app/controllers/JobController.php`
- `app/models/Job.php`
- `views/jobs/_form.php`, `create.php`, `edit.php`, `show.php`, `index.php`
- `public/assets/css/jobs.css`
- `public/assets/js/jobs.js`
- `database/upgrade-jobs.php`
- `docs/crud-candidaturas.md`

**Não substitua** `views/layouts/header.php`, `views/layouts/footer.php`, `views/shared/profile-menu.php`, nem `public/index.php` pelo código de versões anteriores. Os ajustes a seguir são pontuais.

## 3. Execute a atualização segura do banco

Inicie o MySQL no Laragon. Faça backup do banco pelo HeidiSQL ou phpMyAdmin.

No terminal do VS Code, dentro de `C:\laragon\www\devtrack`, execute:

```powershell
php database/upgrade-jobs.php
```

Esse script cria `job_applications` se não existir ou **adiciona apenas as colunas que faltarem**, sem apagar registros. Ele espera encontrar a tabela `users` criada pela autenticação e a conexão PDO em `app/config/database.php`. Se a tabela existente tem uma estrutura incompatível, o script **avisa e interrompe**, ao invés de apagá-la.

## 4. Adicione a rota ao `public/index.php`

**ATENÇÃO: não substitua o roteador inteiro**, porque nele estão as rotas de login, registro, logout e avatar. Abra `public/index.php` e coloque este bloco **DEPOIS** das rotas POST de autenticação e da rota `avatar-upload`, mas **ANTES** de `if ($method !== 'GET')`:

```php
// CRUD de candidaturas: lida com GET e POST.
if ($page === 'jobs') {
    require __DIR__ . '/../app/middleware/auth.php';
    require_once __DIR__ . '/../app/controllers/JobController.php';
    (new JobController())->handle($method);
}
```

O array `$routes` pode continuar contendo `'jobs' => 'shared/coming-soon.php'` por enquanto, pois o bloco acima tratará essa página primeiro. Se quiser, remova essa entrada antiga para evitar confusão.

## 5. Importe CSS e JS nos layouts já existentes

Em `views/layouts/header.php`, no `<head>` **depois** do `style.css`, acrescente:

```html
<link rel="stylesheet" href="assets/css/jobs.css">
```

Em `views/layouts/footer.php`, **antes** de `</body>`, acrescente:

```html
<script src="assets/js/jobs.js" defer></script>
```

Os arquivos novos usam as variáveis CSS existentes (`--bg`, `--surface`, `--accent`, `--border`, etc.), por isso respeitam os modos claro e escuro do projeto.

## 6. Teste o CRUD

1. Entre com tua conta e abre `http://devtrack.test/index.php?page=jobs`.
2. Clique em **Nova candidatura**, cadastre uma vaga fictícia e salve.
3. Volte para a listagem; pesquise, filtre e edite a vaga.
4. Em Detalhes, altere o status e confira a persistência.
5. Teste exclusão e confirmação.
6. Se tiver duas contas de teste, confirme que uma conta **não vê** as vagas da outra.
7. Teste sem login e com requisições POST sem token CSRF.
8. Confira o tema claro/escuro e a responsividade.

**Nota:** neste pacote, somente a página **Candidaturas** fica conectada ao MySQL. O Kanban e os números da tela Dashboard ainda são demonstrativos. A integração virá na v0.5.0-beta.

## 7. Documentação e versionamento

Depois de testar, adicione em `docs/README.md`:

```markdown
- [Job Applications CRUD](./crud-candidaturas.md)
```

Atualize a documentação principal para `v0.4.0-alpha` **somente após confirmar que funciona no teu Laragon**.

Commit sugerido:

```bash
git add app/controllers/JobController.php app/models/Job.php views/jobs/ public/assets/css/jobs.css public/assets/js/jobs.js database/upgrade-jobs.php docs/crud-candidaturas.md public/index.php views/layouts/header.php views/layouts/footer.php
git commit -m "feat: implement job application CRUD with ownership validation"
git push
```

## 8. Soluções para problemas comuns

- **'Método não permitido' no cadastro:** bloco da rota `jobs` precisa ficar antes do bloqueio geral de POST.
- **'Página em desenvolvimento':** o bloco da rota `jobs` não está ativo ou ficou depois do array `$routes`.
- **Tabela não encontrada:** execute a migração com o MySQL iniciado.
- **Erro de conexão:** confira porta, usuário e banco em `app/config/database.php`.
- **CSS não carrega:** confirme a URL `http://devtrack.test/assets/css/jobs.css`.
- **Um usuário vê dados do outro:** pare e confira `user_id` no Model; toda operação precisa filtrar pelo ID da sessão.

Esta versão é uma implementação inicial. Não faça deploy público sem revisar segurança, backups e testes automatizados.
