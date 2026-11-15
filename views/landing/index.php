<?php
// O botão principal aponta para o painel apenas se houver sessão autenticada.
// Até implementar login/registro, os visitantes são encaminhados às páginas atuais de autenticação.
$isLoggedIn = !empty($_SESSION['user_id']);
$primaryUrl = $isLoggedIn ? 'index.php?page=dashboard' : 'index.php?page=register';
$primaryLabel = $isLoggedIn ? 'Ir para o Dashboard' : 'Começar gratuitamente';
?>
<main>
    <section class="landing-hero landing-container" aria-labelledby="landing-hero-title">
        <div class="hero-copy">
            <div class="landing-eyebrow">
                <span class="eyebrow-dot"></span>
                Organize <span class="dot-divider">·</span> Candidate-se <span class="dot-divider">·</span> Evolua
            </div>
            <h1 id="landing-hero-title">Gerencie suas candidaturas e desenvolva suas <span>habilidades.</span></h1>
            <p class="hero-description">Organize suas oportunidades, acompanhe processos seletivos e descubra o que estudar com base nas tecnologias pedidas pelo mercado.</p>
            <div class="hero-actions">
                <a class="landing-btn landing-btn-primary landing-btn-lg" href="<?= $primaryUrl ?>">
                    <?= htmlspecialchars($primaryLabel, ENT_QUOTES, 'UTF-8') ?>
                    <svg class="icon" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
                <a class="landing-btn landing-btn-outline landing-btn-lg" href="#demonstracao">
                    <svg class="icon" aria-hidden="true"><use href="#i-play"/></svg>
                    Ver demonstração
                </a>
            </div>
            <div class="hero-notes" aria-label="Destaques do projeto">
                <span><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Focado em desenvolvedores</span>
                <span><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Tema claro e escuro</span>
                <span><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Em desenvolvimento</span>
            </div>
        </div>
        <div class="hero-visual" aria-label="Prévia ilustrativa do painel DevTrack">
            <div class="hero-orbit hero-orbit-one" aria-hidden="true"></div>
            <div class="hero-orbit hero-orbit-two" aria-hidden="true"></div>
            <div class="dashboard-image-frame">
                <div class="browser-chrome" aria-hidden="true">
                    <span class="chrome-dots"><i></i><i></i><i></i></span>
                    <span class="chrome-url"><svg class="icon" aria-hidden="true"><use href="#i-code"/></svg> devtrack.test / dashboard</span>
                </div>
                <img src="assets/img/dashboard-preview.webp" width="1400" height="788" alt="Prévia ilustrativa do dashboard: indicadores, Kanban de candidaturas e Área de Estudos" fetchpriority="high">
            </div>
            <span class="visual-caption">Conceito visual • dados de demonstração</span>
        </div>
    </section>

    <section class="features-section" id="recursos" aria-labelledby="features-title">
        <div class="landing-container">
            <div class="section-intro section-intro-centered">
                <span class="section-kicker">PRINCIPAIS RECURSOS</span>
                <h2 id="features-title">Tudo o que você precisa para sua <span>carreira em tech.</span></h2>
                <p>Do primeiro currículo à próxima entrevista: acompanhe cada etapa e descubra onde evoluir.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card">
                    <span class="feature-icon"><svg class="icon" aria-hidden="true"><use href="#i-briefcase"/></svg></span>
                    <h3>Organize suas candidaturas</h3>
                    <p>Salve oportunidades, acompanhe os status e mantenha todos os processos seletivos em um lugar.</p>
                    <span class="feature-chip">Kanban de vagas</span>
                </article>
                <article class="feature-card">
                    <span class="feature-icon"><svg class="icon" aria-hidden="true"><use href="#i-chart"/></svg></span>
                    <h3>Entenda o que o mercado pede</h3>
                    <p>Identifique as tecnologias mais frequentes nas vagas que você cadastrou e veja o que priorizar.</p>
                    <span class="feature-chip">Análise de habilidades</span>
                </article>
                <article class="feature-card">
                    <span class="feature-icon"><svg class="icon" aria-hidden="true"><use href="#i-cap"/></svg></span>
                    <h3>Evolua com foco</h3>
                    <p>Transforme exigências de vagas em prioridades de estudo e organize seu crescimento profissional.</p>
                    <span class="feature-chip">Trilhas de aprendizado</span>
                </article>
            </div>
        </div>
    </section>

    <section class="product-section landing-container" id="demonstracao" aria-labelledby="product-title">
        <div class="product-preview" aria-label="Exemplo da Área de Estudos do DevTrack">
            <div class="preview-topbar">
                <span><svg class="icon" aria-hidden="true"><use href="#i-cap"/></svg> Área de Estudos</span>
                <span class="preview-tag">Demonstração</span>
            </div>
            <div class="preview-body">
                <h3>Tecnologias nas vagas salvas</h3>
                <p>Um exemplo de como as exigências podem orientar seus estudos.</p>
                <div class="skill-line"><span>JavaScript</span><div class="skill-meter"><i style="width:82%"></i></div><b>82%</b></div>
                <div class="skill-line"><span>SQL</span><div class="skill-meter"><i style="width:74%"></i></div><b>74%</b></div>
                <div class="skill-line"><span>React</span><div class="skill-meter"><i style="width:59%"></i></div><b>59%</b></div>
                <div class="skill-line"><span>PHP</span><div class="skill-meter"><i style="width:43%"></i></div><b>43%</b></div>
                <div class="suggestion-card">
                    <span class="suggestion-icon"><svg class="icon" aria-hidden="true"><use href="#i-target"/></svg></span>
                    <div><strong>Próximo foco: React</strong><p>Aprender componentes, estados e consumo de APIs.</p></div>
                </div>
            </div>
            <span class="preview-disclaimer">Números ilustrativos. A análise automática será implementada em uma próxima versão.</span>
        </div>
        <div class="product-copy">
            <span class="section-kicker">MAIS QUE UMA LISTA DE VAGAS</span>
            <h2 id="product-title">Uma ferramenta feita para quem está começando na <span>área de tecnologia.</span></h2>
            <p>O DevTrack une dois desafios reais: acompanhar suas candidaturas e descobrir quais habilidades desenvolver para buscar oportunidades com mais preparo.</p>
            <ul class="product-benefits">
                <li><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Acompanhe cada etapa do processo seletivo</li>
                <li><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Compare tecnologias exigidas nas vagas</li>
                <li><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Organize objetivos de aprendizado</li>
                <li><svg class="icon" aria-hidden="true"><use href="#i-check"/></svg> Visualize sua evolução no mesmo lugar</li>
            </ul>
            <a class="landing-text-link" href="https://github.com/luizsendret0/devtrack" target="_blank" rel="noopener noreferrer">
                Conhecer o código no GitHub <svg class="icon" aria-hidden="true"><use href="#i-arrow-right"/></svg>
            </a>
        </div>
    </section>

    <section class="steps-section" id="como-funciona" aria-labelledby="steps-title">
        <div class="landing-container">
            <div class="section-intro section-intro-centered">
                <span class="section-kicker">COMO FUNCIONA</span>
                <h2 id="steps-title">Sua jornada, em três passos.</h2>
                <p>Uma experiência simples para organizar oportunidades e planejar os próximos estudos.</p>
            </div>
            <div class="steps-grid">
                <div class="step-item"><span class="step-number">01</span><h3>Crie sua conta</h3><p>Em breve, você poderá ter seu espaço pessoal e manter seus dados organizados.</p></div>
                <div class="step-item"><span class="step-number">02</span><h3>Adicione suas vagas</h3><p>Cadastre oportunidades e acompanhe o andamento de cada candidatura.</p></div>
                <div class="step-item"><span class="step-number">03</span><h3>Estude com direção</h3><p>Descubra as tecnologias mais exigidas e monte uma trilha focada em seus objetivos.</p></div>
            </div>
        </div>
    </section>

    <section class="final-section landing-container" id="sobre" aria-labelledby="final-title">
        <div class="final-cta">
            <div class="final-cta-graphic" aria-hidden="true"><svg class="icon"><use href="#i-code"/></svg></div>
            <div>
                <span class="section-kicker">UM PROJETO EM EVOLUÇÃO</span>
                <h2 id="final-title">Pronto para organizar sua jornada em tecnologia?</h2>
                <p>Conheça o DevTrack e acompanhe a construção de uma ferramenta pensada para quem está iniciando na área.</p>
            </div>
            <a class="landing-btn landing-btn-primary landing-btn-lg" href="<?= $primaryUrl ?>">
                <?= htmlspecialchars($primaryLabel, ENT_QUOTES, 'UTF-8') ?>
                <svg class="icon" aria-hidden="true"><use href="#i-arrow-right"/></svg>
            </a>
        </div>
    </section>
</main>
