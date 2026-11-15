# Landing Page — DevTrack

**Versão:** `v0.2.1-alpha`  
**Tipo:** Página pública de apresentação  
**Status:** Implementada nos arquivos da etapa; validar integração e comportamento no Laragon local  
**Próximo marco:** `v0.3.0-alpha` — autenticação

## 1. Objetivo

Apresentar o DevTrack para visitantes sem exigir conta e explicar a proposta de valor: **acompanhar candidaturas a vagas de tecnologia** e, em versões posteriores, **orientar estudos a partir das exigências das vagas cadastradas**.

A landing **não substitui** o dashboard: é a porta de entrada pública da aplicação. O dashboard e suas candidaturas serão privados quando a autenticação for implementada.

## 2. Público e jornada do usuário

- **Visitante sem conta:** pode ler a landing e acessar as páginas de entrar/cadastrar; ainda não usa o dashboard com dados reais.
- **Usuário cadastrado, mas deslogado:** continua podendo acessar a landing; precisa fazer login para acessar a área privada.
- **Usuário com sessão autenticada:** pode permanecer na landing e usar o botão **Ir para o Dashboard**.

```text
Landing pública (/)
├── Recursos (#recursos)
├── Demonstração (#demonstracao)
├── Como funciona (#como-funciona)
├── Sobre (#sobre)
├── Entrar (?page=login)           [ainda temporário na v0.2.1-alpha]
└── Criar conta (?page=register)   [ainda temporário na v0.2.1-alpha]

Sessão autenticada (previsto para v0.3.0-alpha)
└── Ir para o Dashboard (?page=dashboard)
```

> A landing e os links de navegação já foram criados. **A existência dos links não significa que login, cadastro ou proteção de rotas já funcionem.** Antes da autenticação, o dashboard continua sem controle de acesso real.

## 3. Seções implementadas na interface

| Seção | Âncora / Local | Conteúdo |
| --- | --- | --- |
| Cabeçalho | `landing-header.php` | Logo, links de navegação, alternância de tema e ações de conta |
| Hero | início da landing | Título, descrição, **Começar gratuitamente**, **Ver demonstração** e prévia ilustrativa do dashboard |
| Recursos | `#recursos` | Cards: candidaturas, análise de habilidades e trilhas de aprendizado |
| Demonstração | `#demonstracao` | Visualização **fictícia** da Área de Estudos, com percentuais de exemplo |
| Como funciona | `#como-funciona` | Três passos: criar conta, adicionar vagas e estudar com direção |
| CTA final | `#sobre` | Convite para conhecer/usar o DevTrack, conforme a sessão |
| Rodapé | `landing-footer.php` | Navegação, GitHub e identificação do projeto |

**Observação:** a prévia do dashboard é um arquivo WEBP ilustrativo e os percentuais de tecnologias mostrados na demonstração não vêm do MySQL.

## 4. Requisitos funcionais específicos da landing (RF)

| Código | Requisito | Situação |
| --- | --- | --- |
| RF-LP-01 | Abrir a landing na rota pública `/` (`?page=landing` também pode ser usado). | Desenvolvido; testar localmente |
| RF-LP-02 | Mostrar o propósito do produto e as seções Hero, Recursos, Demonstração, Como funciona e Sobre. | Desenvolvido |
| RF-LP-03 | Oferecer links de **Entrar** e **Criar conta** aos visitantes. | Links criados; autenticação pendente |
| RF-LP-04 | Exibir CTA **Ir para o Dashboard** quando houver sessão autenticada válida. | Lógica condicional preparada; integração pendente |
| RF-LP-05 | Permitir navegar pelas seções internas por links de âncora. | Desenvolvido; testar localmente |
| RF-LP-06 | Alternar temas claro e escuro, reutilizando a preferência `devtrack-theme` do dashboard. | Desenvolvido; testar integração |
| RF-LP-07 | Permitir abrir/fechar menu mobile, incluindo fechamento por `Escape` ou clique em link. | Desenvolvido; testar localmente |
| RF-LP-08 | Oferecer acesso ao repositório do projeto no GitHub. | Desenvolvido |
| RF-LP-09 | Mostrar aviso de demonstração para valores e funcionalidades ainda ilustrativos. | Desenvolvido |

## 5. Requisitos não funcionais específicos da landing (RNF)

| Código | Requisito | Verificação |
| --- | --- | --- |
| RNF-LP-01 | Ser responsiva para desktop, tablet e celular. | Conferir em 360, 768 e 1440 px |
| RNF-LP-02 | Ser utilizável por teclado, com foco visível e botão de menu acessível. | Navegar com Tab, Enter e Escape |
| RNF-LP-03 | Não depender de frameworks JavaScript ou serviços externos para a interface básica. | Testar localmente, sem CDN |
| RNF-LP-04 | Utilizar prévia de imagem otimizada em WEBP com atributo `alt`. | Inspecionar imagem e HTML |
| RNF-LP-05 | Manter CSS/JS separados do dashboard para evitar conflitos. | Conferir `landing.css` e `landing.js` |
| RNF-LP-06 | Compartilhar a preferência de tema usando `localStorage`, com fallback caso indisponível. | Alternar tema, recarregar e abrir dashboard |
| RNF-LP-07 | Não mostrar valores fictícios como indicadores reais ou funcionalidades já disponíveis. | Revisar textos e avisos da demonstração |

## 6. Regras de negócio da landing (RN)

| Código | Regra |
| --- | --- |
| RN-LP-01 | A landing é pública para visitantes e usuários autenticados. |
| RN-LP-02 | Estar cadastrado não é estar logado: só uma **sessão autenticada válida** autoriza acesso a páginas privadas (exigência da v0.3.0-alpha). |
| RN-LP-03 | Visitantes recebem CTAs de login/cadastro; usuários autenticados recebem CTA para o dashboard. |
| RN-LP-04 | Os números, cartões e gráficos de prévia devem continuar identificados como **demonstrativos** até a integração com dados reais. |
| RN-LP-05 | Os textos da landing podem apresentar a visão do produto, mas não podem afirmar que o cadastro, a análise automática ou a recomendação de estudos já estão funcionando. |
| RN-LP-06 | A escolha de tema feita na landing deve valer também no dashboard e vice-versa, quando acessados no mesmo navegador. |

## 7. Identidade visual

- **Modo escuro:** fundo quase preto, superfícies azul-marinho e destaque azul-ciano.
- **Modo claro:** fundo branco/azul muito claro, superfícies claras e destaque azul.
- **Estética:** cartões arredondados, Glassmorphism discreto, boa legibilidade e layout responsivo.
- **Persistência:** chave `devtrack-theme` no `localStorage`, compartilhada com o dashboard.

## 8. Arquivos envolvidos

```text
public/
├── index.php                       # ponto de entrada e seleção de rota
└── assets/
    ├── css/landing.css             # estilos exclusivos da landing
    ├── js/landing.js               # tema e menu responsivo
    └── img/dashboard-preview.webp  # ilustração do dashboard
views/
├── landing/index.php               # seções e conteúdo da landing
└── layouts/
    ├── landing-header.php          # head, menu, CTAs e ícones
    └── landing-footer.php          # rodapé e script
```

**Atenção:** o `public/index.php` também contém o roteamento já existente. Ao integrar, preservar as outras rotas e os layouts do dashboard.

## 9. Critérios de aceite — checklist de teste manual

- [ ] Abrir `http://devtrack.test/` sem login e ver a landing, **sem a sidebar do dashboard**.
- [ ] Clicar em **Entrar** e **Criar conta** e chegar às rotas existentes (ainda temporárias).
- [ ] Clicar em **Ver demonstração** e navegar até a prévia da Área de Estudos.
- [ ] Verificar links **Recursos**, **Como funciona**, **Sobre** e **GitHub**.
- [ ] Alternar entre temas, recarregar e comprovar que a escolha permanece.
- [ ] Alternar o tema na landing e abrir o dashboard para conferir consistência.
- [ ] Em 360 px de largura, confirmar ausência de rolagem horizontal indevida.
- [ ] Em celular, abrir/fechar menu, clicar em um link e pressionar `Escape`.
- [ ] Confirmar que dados demonstrativos estão corretamente identificados.
- [ ] Após implementar login, testar usuário autenticado, visitante e usuário deslogado.

Estes itens devem ser marcados apenas depois de testar no ambiente local; a entrega de arquivos não prova o comportamento no computador do usuário.

## 10. Próximos passos

- **`v0.3.0-alpha`:** telas de cadastro/login, sessões, hash de senha, logout, CSRF e bloqueio efetivo das páginas privadas.
- **`v0.4.0-alpha`:** CRUD de candidaturas persistidas no MySQL.
- **`v0.5.0-beta`:** dashboard/Kanban com dados reais.
- **`v1.1`:** análises de tecnologias e recomendações de estudos baseadas nas vagas.
