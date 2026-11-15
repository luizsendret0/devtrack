# Landing Page — DevTrack

**Marco proposto:** `v0.2.1-alpha`  
**Situação:** interface pública criada antes da autenticação.

## Objetivo

Apresentar o DevTrack e seu diferencial (organização de candidaturas + estudo orientado por vagas) sem exigir login. Usuários já logados poderão continuar visitando a landing e entrar no dashboard pelo botão principal.

## Requisitos funcionais

- **RF-LP-01:** O sistema deve exibir a landing pública na rota `/`.
- **RF-LP-02:** A página deve apresentar propósito, recursos, demonstração ilustrativa e informações do projeto.
- **RF-LP-03:** O visitante deve encontrar links para login e cadastro.
- **RF-LP-04:** Usuários autenticados devem visualizar um botão de acesso ao dashboard.
- **RF-LP-05:** A navegação por âncoras deve levar às seções internas da landing.
- **RF-LP-06:** O botão de alternância de temas deve compartilhar a preferência com o dashboard.
- **RF-LP-07:** O menu mobile deve abrir, fechar e permitir navegação por teclado.

## Requisitos não funcionais

- **RNF-LP-01:** Layout responsivo em telas desktop, tablet e mobile.
- **RNF-LP-02:** Elementos interativos acessíveis por teclado, com indicadores de foco visíveis.
- **RNF-LP-03:** Não depender de bibliotecas externas para renderizar a interface.
- **RNF-LP-04:** Usar imagem WEBP otimizada e texto alternativo na prévia.
- **RNF-LP-05:** A landing deve operar independentemente do CSS do dashboard.

## Regras de negócio

- **RN-LP-01:** A landing sempre será acessível sem autenticação.
- **RN-LP-02:** Estar cadastrado não significa estar logado: somente sessões autenticadas terão CTA direto para o dashboard.
- **RN-LP-03:** Números e imagens de demonstração devem ser identificados como ilustrativos.
- **RN-LP-04:** Nenhuma funcionalidade ainda não implementada será anunciada como disponível para uso.

## Critérios de aceite

1. `http://devtrack.test/` abre a landing, sem mostrar sidebar do dashboard.
2. Links de login e cadastro apontam para as rotas existentes.
3. `http://devtrack.test/?page=dashboard` mantém a interface atual (até implementar proteção de sessão).
4. A escolha do modo claro/escuro persiste após recarregar a página e é compatível com o botão do dashboard.
5. O menu mobile funciona e fecha após clicar em um link ou pressionar `Escape`.
6. Não há scroll horizontal no celular; a prévia e os cartões se adaptam à largura da tela.
7. As seções e o rodapé funcionam sem banco de dados.

## Próximas versões

- `v0.3.0-alpha`: autenticação, criação de conta, login/logout e rotas privadas.
- `v0.4.0-alpha`: CRUD de candidaturas ligado ao MySQL.
- `v0.6.0-beta`: análise real de tecnologias e recomendações de estudo.
