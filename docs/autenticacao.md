# Autenticação — DevTrack

**Marco:** `v0.3.0-alpha`  
**Implementação:** PHP puro + PDO + MySQL + sessões  
**Estado:** código da etapa entregue, testes no Laragon pendentes

## Objetivo

- Cadastrar usuário com nome, e-mail único e senha armazenada como hash.
- Realizar login pelo e-mail e senha.
- Criar sessão e renovar o identificador após login/cadastro.
- Exigir login no dashboard e nas demais páginas privadas.
- Oferecer logout por POST com token CSRF.
- Preservar landing pública para visitantes e pessoas logadas.

## Regras de negócio

| ID | Regra |
|---|---|
| RN-AUTH-01 | E-mails são normalizados para minúsculas e únicos no banco. |
| RN-AUTH-02 | Registro exige nome, e-mail, senha e confirmação. |
| RN-AUTH-03 | A senha deve conter entre 8 e 72 bytes, respeitando o limite atual do bcrypt. |
| RN-AUTH-04 | Apenas sessões autenticadas acessam páginas privadas. |
| RN-AUTH-05 | Logout exige POST e CSRF válido. |
| RN-AUTH-06 | Credenciais incorretas não revelam se o e-mail existe. |

## Requisitos funcionais

| ID | Requisito |
|---|---|
| RF-AUTH-01 | Exibir formulário de registro na rota `?page=register`. |
| RF-AUTH-02 | Validar registro no servidor e inserir usuário no MySQL. |
| RF-AUTH-03 | Exibir formulário de login na rota `?page=login`. |
| RF-AUTH-04 | Verificar senha via `password_verify()` e iniciar sessão. |
| RF-AUTH-05 | Redirecionar visitantes de páginas privadas para login. |
| RF-AUTH-06 | Encerrar sessão ao clicar em Sair. |
| RF-AUTH-07 | Preservar preferência de tema na landing, login, registro e dashboard. |

## Requisitos não funcionais

| ID | Requisito |
|---|---|
| RNF-AUTH-01 | Consultas ao banco devem usar PDO com parâmetros preparados. |
| RNF-AUTH-02 | Senhas devem usar `password_hash(PASSWORD_DEFAULT)`; nunca texto puro. |
| RNF-AUTH-03 | Formulários POST devem usar proteção CSRF. |
| RNF-AUTH-04 | Cookies de sessão devem usar HttpOnly, SameSite=Lax e Secure quando HTTPS. |
| RNF-AUTH-05 | Interfaces responsivas e acessíveis por teclado. |
| RNF-AUTH-06 | Exceções do banco não devem ser exibidas ao usuário final. |

## Fluxo

```text
Visitante -> Landing Page -> Login ou Registro -> Dashboard privado
Usuário logado -> Landing Page -> Dashboard
Dashboard -> Logout (POST/CSRF) -> Landing Page
```

## Critérios de aceite (marcar após testar no Laragon)

- [ ] Landing abre sem login.
- [ ] Dashboard sem sessão redireciona para login.
- [ ] Cadastro válido grava um usuário em `users`.
- [ ] Senha salva no banco é um hash, nunca a senha original.
- [ ] E-mail repetido apresenta erro sem criar novo usuário.
- [ ] Senhas diferentes impedem cadastro.
- [ ] Login com senha errada não entra.
- [ ] Login correto abre dashboard.
- [ ] Landing exibe CTA para dashboard com sessão ativa.
- [ ] Logout retorna à landing e impede acesso privado.
- [ ] POST sem CSRF válido não cria sessão nem usuário.
- [ ] Tema é preservado entre as páginas.

## Limitações atuais

Sem recuperação de senha, verificação de e-mail, 2FA nem envio de mensagens. O bloqueio de tentativas é por sessão do navegador: **não substitui rate limiting por IP/conta em produção**. Antes de publicar com usuários reais, configurar HTTPS, proteção contra abuso, logs e gestão de segredos, além de testes automatizados.

## Código

- `app/controllers/AuthController.php`: validações e ações de cadastro/login/logout.
- `app/models/User.php`: consultas com PDO.
- `app/helpers/security.php`: CSRF, escaping, redirecionamento e mensagens de formulário.
- `app/config/session.php`: sessão e cookie.
- `app/middleware/auth.php`: bloqueio das rotas privadas.
- `views/auth/`: formulários.
- `views/layouts/auth-header.php` e `auth-footer.php`: layout público separado.
- `public/index.php`: integra rotas públicas e privadas.
- `views/shared/logout-button.php`: botão de logout para adicionar ao dashboard.
