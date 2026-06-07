<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pixnit — Application de bureau</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="app-hero">
    <div class="app-badge">
        <span class="app-badge-dot"></span>
        Application de bureau — Python · PyQt6
    </div>

    <h1 class="app-title">
        Crée tes patrons pixel<br>
        sur ton <span>ordinateur</span>
    </h1>

    <p class="app-desc">
        Importe n'importe quelle image, pixelise-la en quelques clics,
        ajuste chaque couleur à la main — puis publie directement sur pixknit.
    </p>

    <div class="hero-actions">
        <a href="https://github.com/Misskine/Pixnit/archive/refs/heads/main.zip" class="dl-btn" target="_blank">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Télécharger le code source
        </a>
        <a href="https://github.com/Misskine/Pixnit" class="dl-btn-ghost" target="_blank">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.73.083-.73 1.205.085 1.84 1.238 1.84 1.238 1.07 1.835 2.807 1.305 3.492.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23a11.5 11.5 0 0 1 3-.405c1.02.005 2.045.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
            Voir sur GitHub
        </a>
    </div>

    <div class="app-window">
        <div class="app-window-bar">
            <span class="app-window-dot" style="background:#ff5f57;"></span>
            <span class="app-window-dot" style="background:#febc2e;"></span>
            <span class="app-window-dot" style="background:#28c840;"></span>
            <span class="app-window-label">Pixnit — éditeur de patrons pixel</span>
        </div>
        <div class="app-window-content">
            <div class="app-panel">
                <p class="app-panel-title">Outils</p>
                <div class="app-tool-btn active">Crayon</div>
                <div class="app-tool-btn">Remplir</div>
                <div class="app-tool-btn">Loupe</div>
                <div class="app-tool-btn">Annuler</div>
                <p class="app-panel-title mt">Grille</p>
                <div class="app-tool-btn">Afficher grille</div>
                <div class="app-tool-btn">30 × 30 px</div>
            </div>
            <div class="app-canvas-area">
                <div>
                    <div class="app-pixel-grid" style="grid-template-columns:repeat(12,14px);">
                        <?php
                        $colors = [
                            '#f5f5f5','#c8f062','#c8f062','#f5f5f5','#f5f5f5','#1c1c1c','#1c1c1c','#f5f5f5','#f5f5f5','#c8f062','#c8f062','#f5f5f5',
                            '#c8f062','#c8f062','#1c1c1c','#c8f062','#1c1c1c','#c8f062','#c8f062','#1c1c1c','#c8f062','#1c1c1c','#c8f062','#c8f062',
                            '#c8f062','#1c1c1c','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#1c1c1c','#c8f062',
                            '#f5f5f5','#c8f062','#c8f062','#c8f062','#1c1c1c','#1c1c1c','#1c1c1c','#1c1c1c','#c8f062','#c8f062','#c8f062','#f5f5f5',
                            '#f5f5f5','#f5f5f5','#c8f062','#1c1c1c','#c8f062','#c8f062','#c8f062','#c8f062','#1c1c1c','#c8f062','#f5f5f5','#f5f5f5',
                            '#f5f5f5','#f5f5f5','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#f5f5f5','#f5f5f5',
                            '#f5f5f5','#c8f062','#1c1c1c','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#c8f062','#1c1c1c','#c8f062','#f5f5f5',
                            '#c8f062','#1c1c1c','#c8f062','#c8f062','#f5f5f5','#f5f5f5','#f5f5f5','#f5f5f5','#c8f062','#c8f062','#1c1c1c','#c8f062',
                        ];
                        foreach($colors as $c): ?>
                            <div class="app-pixel" style="background:<?= $c ?>"></div>
                        <?php endforeach; ?>
                    </div>
                    <p class="app-canvas-label">pixel 6 × 4 — zoom 100%</p>
                </div>
            </div>
            <div class="app-panel">
                <p class="app-panel-title">Couleurs</p>
                <div class="color-swatches">
                    <span class="app-color-swatch active" style="background:#c8f062;"></span>
                    <span class="app-color-swatch" style="background:#1c1c1c;"></span>
                    <span class="app-color-swatch" style="background:#f5f5f5;"></span>
                    <span class="app-color-swatch" style="background:#e05c3a;"></span>
                    <span class="app-color-swatch" style="background:#4a90d9;"></span>
                    <span class="app-color-swatch" style="background:#f5c842;"></span>
                    <span class="app-color-swatch" style="background:#7b4f2e;"></span>
                    <span class="app-color-swatch" style="background:#a8d8a8;"></span>
                </div>
                <p class="app-panel-title mt">Export</p>
                <div class="app-tool-btn clickable">PNG avec grille</div>
                <div class="app-tool-btn clickable">PNG sans grille</div>
                <div class="app-tool-btn clickable">JSON patron</div>
                <div class="app-tool-btn active clickable mt">Publier sur pixnit</div>
            </div>
        </div>
    </div>
</div>

<div class="features-grid">
    <div class="feature-item">
        <div class="feature-icon">
            <img src="assets/laptopicon.jpg" alt="Import d'image">
        </div>
        <h3>Import d'image</h3>
        <p>Charge n'importe quelle photo ou illustration et pixelise-la automatiquement avec le nombre de mailles souhaité.</p>
    </div>
    <div class="feature-item">
        <div class="feature-icon">
            <img src="assets/iconyarn.jpg" alt="Éditeur pixel">
        </div>
        <h3>Éditeur pixel</h3>
        <p>Modifie chaque pixel à la main — crayon, remplissage, pipette. Ajuste les couleurs pour les adapter à ta palette de laine.</p>
    </div>
    <div class="feature-item">
        <div class="feature-icon">
            <img src="assets/heartkniticon.png" alt="Recadrage & rotation">
        </div>
        <h3>Recadrage & rotation</h3>
        <p>Recadre, pivote et retourne ton image directement dans l'éditeur avant de pixeliser.</p>
    </div>
    <div class="feature-item">
        <div class="feature-icon">
            <img src="assets/sendicon.jpg" alt="Export PNG & JSON">
        </div>
        <h3>Export PNG & JSON</h3>
        <p>Exporte ton patron en PNG avec ou sans grille de référence, ou en JSON pour l'importer directement sur pixnit.</p>
    </div>
</div>

<div class="steps-section">
    <div class="steps-header">
        <span class="steps-badge">Comment ça marche</span>
        <h2 class="steps-title">De l'image au patron<br><em>en 4 étapes</em></h2>
    </div>
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-num">1</div>
            <h4>Télécharger l'app</h4>
            <p>Télécharge le code source depuis GitHub et installe les dépendances Python avec <code class="step-code">pip install -r requirements.txt</code></p>
        </div>
        <div class="step-card">
            <div class="step-num">2</div>
            <h4>Importer ton image</h4>
            <p>Charge une photo, une illustration ou un dessin depuis ton ordinateur dans l'éditeur Pixnit.</p>
        </div>
        <div class="step-card">
            <div class="step-num">3</div>
            <h4>Pixeliser & ajuster</h4>
            <p>Règle la taille de la grille, modifie les couleurs pixel par pixel pour coller à ta palette de laine.</p>
        </div>
        <div class="step-card">
            <div class="step-num">4</div>
            <h4>Exporter & partager</h4>
            <p>Exporte en PNG ou JSON, ou publie directement sur pixknit depuis l'application.</p>
        </div>
    </div>
</div>

<div class="requirements-section">
    <h2>Configuration requise</h2>
    <div class="requirements-grid">
        <div class="req-card">
            <p class="pixel-label label">Système</p>
            <p class="body">Windows 10/11<br>macOS 11+<br>Linux (Ubuntu 20+)</p>
        </div>
        <div class="req-card">
            <p class="pixel-label label">Prérequis</p>
            <p class="body">Python 3.10+<br>PyQt6<br>Pillow (PIL)</p>
        </div>
        <div class="req-card highlight">
            <p class="pixel-label label">Installation rapide</p>
            <code>git clone github.com/<br>Misskine/Pixnit<br>pip install -r requirements.txt<br>python main.py</code>
        </div>
    </div>
</div>

<div class="cta-section">
    <img src="assets/logo.svg" alt="Pixnit" width="56" height="56" class="cta-logo">
    <h2>Prêt·e à créer ?</h2>
    <p>Télécharge Pixnit et commence à transformer tes images en patrons.</p>
    <div class="cta-actions">
        <a href="https://github.com/Misskine/Pixnit/archive/refs/heads/main.zip" class="cta-btn-dark">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Télécharger le code source (.zip)
        </a>
        <a href="https://github.com/Misskine/Pixnit" target="_blank" class="cta-btn-outline">
            Voir sur GitHub
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
