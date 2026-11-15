# DevTrack — Implementação da landing page

## 1. Faça backup

Antes de substituir qualquer arquivo existente, salve uma cópia do seu `public/index.php`.

## 2. Copie os arquivos

Copie o conteúdo das pastas `views`, `public/assets` e `docs` para as mesmas pastas do projeto em `C:\laragon\www\devtrack`.

Os arquivos de estilo e scripts da landing são **novos**, não alteram o CSS/JS do dashboard:

- `views/layouts/landing-header.php`
- `views/landing/index.php`
- `views/layouts/landing-footer.php`
- `public/assets/css/landing.css`
- `public/assets/js/landing.js`
- `public/assets/img/dashboard-preview.webp`
- `docs/landing-page.md`

## 3. Integração de rotas

O arquivo `public/index.php` incluído é uma versão compatível com as rotas que planejamos nesta conversa. Se o seu atual `public/index.php` tiver modificações importantes, **não substitua sem comparar**.

Se preferir fazer a edição mínima, no início do `public/index.php`, antes de carregar o `views/layouts/header.php`:

```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'landing';

if ($page === 'landing') {
    require __DIR__ . '/../views/layouts/landing-header.php';
    require __DIR__ . '/../views/landing/index.php';
    require __DIR__ . '/../views/layouts/landing-footer.php';
    exit;
}
```

Mantenha seu array `$routes` atual e o restante do roteador como estão. Não duplique a declaração de `$page` desnecessariamente.

## 4. Testar

Com o Apache do Laragon ligado e o virtual host apontando para `devtrack/public`, abra:

- Landing: `http://devtrack.test/`
- Dashboard: `http://devtrack.test/?page=dashboard`
- Login (ainda temporário): `http://devtrack.test/?page=login`
- Cadastro (ainda temporário): `http://devtrack.test/?page=register`

Na landing, teste: âncoras, menu mobile, troca de tema, responsividade e links de navegação.

## 5. Limitação proposital da etapa

O botão **Criar conta** leva à página atual de cadastro, mas o registro e login reais ainda não foram implementados. Os dados da prévia do dashboard são ilustrativos. O dashboard ainda precisa ser protegido por autenticação na próxima etapa.

## 6. Versionamento sugerido

Versão: `v0.2.1-alpha` (landing pública implementada).

Commit:

```bash
git add .
git commit -m "feat: add public landing page with responsive themes"
git push
```

No `README.md` da raiz, atualize a versão quando a landing estiver realmente testada e mencione a nova rota pública.
