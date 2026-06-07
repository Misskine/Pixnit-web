<?php
session_start();
require_once 'bd.php';

// Patron vedette (le plus récent)
$stmt = $pdo->query("
    SELECT patrons.*, users.pseudo AS auteur,
           COUNT(likes.patron_id) AS nb_likes
    FROM patrons
    LEFT JOIN users  ON patrons.user_id = users.id
    LEFT JOIN likes  ON patrons.id = likes.patron_id
    GROUP BY patrons.id
    ORDER BY patrons.created_at DESC
    LIMIT 1
");
$vedette = $stmt->fetch();

// Tous les patrons
$stmt = $pdo->query("
    SELECT patrons.*, users.pseudo AS auteur,
           COUNT(likes.patron_id) AS nb_likes
    FROM patrons
    LEFT JOIN users  ON patrons.user_id = users.id
    LEFT JOIN likes  ON patrons.id = likes.patron_id
    GROUP BY patrons.id
    ORDER BY patrons.created_at DESC
");
$patrons = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PixKnit — Patrons pixel</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- ═══ HERO ═══════════════════════════════════════════ -->
<div style="display:grid;grid-template-columns:1fr 1fr;min-height:600px;border-bottom:1.5px solid var(--border-col);">

    <!-- Gauche : photo communauté -->
    <div style="position:relative;overflow:hidden;">
        <img src="assets/you1.jpg" alt="Communauté tricot"
             style="width:100%;height:100%;object-fit:cover;display:block;">
        <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(0,0,0,.15), transparent);"></div>
        <!-- Badge flottant sur la photo -->
        <div style="position:absolute;bottom:28px;left:28px;background:var(--white);border-radius:999px;padding:10px 20px;display:flex;align-items:center;gap:8px;font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;box-shadow:0 4px 20px rgba(0,0,0,.15);">
            <span style="width:8px;height:8px;background:#4ade80;border-radius:50%;display:inline-block;"></span>
            communauté de créateur·ices
        </div>
    </div>

    <!-- Droite : texte + visuels -->
    <div style="background:var(--cream);padding:56px;display:flex;flex-direction:column;justify-content:center;gap:24px;position:relative;overflow:hidden;">

        <!-- pixknit.jpg en fond, derrière tout -->
        <div style="position:absolute;inset:0;z-index:0;">
            <img src="assets/pixknit.jpg" alt="" style="width:100%;height:100%;object-fit:cover;opacity:.08;">
        </div>

        <h1 class="hero-title" style="font-size:60px;text-align:left;max-width:480px;position:relative;z-index:2;">
            Des patrons pixel<br>
            <em>faits maison,</em><br>
            partagés ici.
        </h1>

        <p class="hero-desc" style="text-align:left;position:relative;z-index:2;">
            Transforme tes images en patrons pixel pour le tricot, le crochet,
            le point de croix ou les perler beads — et partage-les avec la communauté.
        </p>

        <!-- Bouton exploreur -->
        <a href="recherche.php" style="position:relative;z-index:2;display:flex;align-items:center;gap:10px;background:var(--white);border:1.5px solid var(--border-col);border-radius:999px;padding:12px 22px;width:fit-content;text-decoration:none;color:var(--dark);transition:border-color .2s,box-shadow .2s;"
           onmouseover="this.style.borderColor='var(--lime)';this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'"
           onmouseout="this.style.borderColor='var(--border-col)';this.style.boxShadow='none'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span style="font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;">Explorer les créations</span>
            <span style="font-size:14px;">→</span>
        </a>

        <div class="hero-actions" style="justify-content:flex-start;position:relative;z-index:2;">
            <a href="#patrons"><button>Voir les patrons ↓</button></a>
            <a href="<?= isset($_SESSION['user_id']) ? 'upload.php' : 'inscription.php' ?>">
                <button class="btn-secondary">+ Partager le mien</button>
            </a>
        </div>

    </div>
</div>

<!-- ═══ TICKER ══════════════════════════════════════════ -->
<div class="ticker">
    <div class="ticker-inner">
        <?php
        $items = ['TRICOT', 'CROCHET', 'PIXEL ART', 'POINT DE CROIX', 'PERLER BEADS', 'FAIT MAISON', 'COMMUNAUTÉ'];
        for ($i = 0; $i < 4; $i++):
            foreach ($items as $item): ?>
                <span><?= $item ?></span><span class="dot">★</span>
        <?php endforeach; endfor; ?>
    </div>
</div>

<!-- ═══ SECTION HISTOIRE ════════════════════════════════ -->
<div style="background:var(--dark);padding:80px 48px;">
<div style="max-width:1200px;margin:0 auto;">

    <!-- Intro éditoriale -->
    <div style="text-align:center;margin-bottom:64px;">
        <span style="display:inline-block;background:var(--lime);color:var(--dark);font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:6px 18px;border-radius:999px;margin-bottom:20px;">
            Le saviez-vous ?
        </span>
        <h2 style="font-family:'Fraunces',serif;font-size:52px;font-weight:900;letter-spacing:-0.02em;color:var(--white);line-height:1.05;max-width:700px;margin:0 auto;">
            Le tricot a <em style="font-style:italic;background:var(--lime);color:var(--dark);padding:0 8px;border-radius:8px;">inventé</em> l'ordinateur.
        </h2>
        <p style="font-size:17px;font-weight:300;color:rgba(255,255,255,.5);margin-top:20px;max-width:520px;margin-left:auto;margin-right:auto;line-height:1.7;">
            Avant les processeurs et les pixels, il y avait les métiers à tisser — et c'est leur logique binaire qui a tout changé.
        </p>
    </div>

    <!-- 4 illustrations en grille — le texte est dans les images -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

        <div style="border-radius:20px;overflow:hidden;">
            <img src="assets/9688cd9630d95e9dd2710a579e089844.jpg"
                 alt="Weaving is the world's oldest binary system"
                 style="width:100%;display:block;border-radius:20px;transition:transform .4s;"
                 onmouseover="this.style.transform='scale(1.02)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>

        <div style="border-radius:20px;overflow:hidden;">
            <img src="assets/634125eb3137fb8a41164b23861143c5.jpg"
                 alt="Jacquard loom 1804"
                 style="width:100%;display:block;border-radius:20px;transition:transform .4s;"
                 onmouseover="this.style.transform='scale(1.02)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>

        <div style="border-radius:20px;overflow:hidden;">
            <img src="assets/infoknit.jpg"
                 alt="A hole = 1 in computer terms"
                 style="width:100%;display:block;border-radius:20px;transition:transform .4s;"
                 onmouseover="this.style.transform='scale(1.02)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>

        <div style="border-radius:20px;overflow:hidden;">
            <img src="assets/75bf0ea16b773cd315d2edc6f9e82c96.jpg"
                 alt="Complex patterns centuries before computers"
                 style="width:100%;display:block;border-radius:20px;transition:transform .4s;"
                 onmouseover="this.style.transform='scale(1.02)'"
                 onmouseout="this.style.transform='scale(1)'">
        </div>

    </div>

</div>
</div>

<!-- ═══ SECTION FEATURES (fond lime) ═══════════════════ -->
<div class="section-lime" style="background-image:url('assets/bg-knit.png');background-size:cover;background-position:center;position:relative;">
    <div class="section-lime-inner" style="position:relative;z-index:1;">
        <div style="text-align:center;margin-bottom:48px;">
            <h2 style="font-family:'Fraunces',serif;font-size:48px;font-weight:900;letter-spacing:-0.02em;color:#fff;line-height:1.0;">
                Pourquoi pixknit ?
            </h2>
            <p style="font-size:17px;font-weight:300;color:rgb(0, 0, 0);margin-top:12px;background:rgba(255,255,255,.9);display:inline-block;padding:8px 16px;border-radius:9px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.6;">
                La plateforme dédiée aux patrons pixel artisanaux
            </p>
        </div>
        <div class="cards-row">
            <div class="feature-card">
                <div class="card-icon"><img src="assets/iconyarn.jpg" alt="Icône pelote de laine" style="width:50%;height:auto;"></div>
                <h3 style="font-style:normal;">Crée ton patron</h3>
                <p>Upload un fichier JSON de grille pixel et vois ton patron prendre vie instantanément.</p>
                <a href="upload.php"><button class="btn-lime" style="align-self:flex-start;">Commencer</button></a>
            </div>
            <div class="feature-card">
                <div class="card-icon"><img src="assets/laptopicon.jpg" alt="Icône ordinateur" style="width:50%;height:auto;"></div>
                <h3 style="font-style:normal;">Partage et inspire</h3>
                <p>Publie tes créations, ajoute des tags et touche une communauté passionnée.</p>
                <a href="inscription.php"><button class="btn-lime" style="align-self:flex-start;">Rejoindre</button></a>
            </div>
            <div class="feature-card">
                <div class="card-icon"><img src="assets/heartkniticon.png" alt="Icône cœur tricoté" style="width:50%;height:auto;"></div>
                <h3 style="font-style:normal;">Like et commente</h3>
                <p>Découvre les patrons des autres, donne des likes et échange dans les commentaires.</p>
                <a href="#patrons"><button class="btn-lime" style="align-self:flex-start;">Explorer</button></a>
            </div>
        </div>
    </div>
</div>

<!-- ═══ CTA (si non connecté) ═══════════════════════════ -->
<?php if (!isset($_SESSION['user_id'])): ?>
<div style="padding:72px 48px;">
    <div class="cta-box">
        <span class="chip chip-dark">avant de continuer</span>
        <h2>Prêt·e à partager<br>ton premier patron ?</h2>
        <p style="color:var(--mid);font-weight:300;max-width:380px;">
            Rejoins la communauté pixknit, c'est gratuit et ouvert à tout le monde.
        </p>
        <a href="inscription.php"><button>Créer un compte →</button></a>
        <a href="connexion.php" style="font-size:13px;color:var(--muted);font-weight:600;text-decoration:underline;text-underline-offset:3px;">
            Déjà un compte ? Se connecter
        </a>
    </div>
</div>
<?php endif; ?>

<!-- ═══ GRILLE DES PATRONS ═══════════════════════════════ -->
<div class="page-wrapper" id="patrons" style="padding-top:0;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <div>
            <h2 style="font-family:'Fraunces',serif;font-size:32px;font-weight:900;letter-spacing:-0.01em;">
                Derniers patrons
            </h2>
            <p class="pixel-label" style="margin-top:4px;">de la communauté</p>
        </div>
        <a href="upload.php">
            <button style="font-size:13px;">+ Partager le mien</button>
        </a>
    </div>

    <?php if (empty($patrons)): ?>
        <div class="empty-state">
            <p>Aucun patron pour l'instant.</p>
            <a href="upload.php"><button>+ Publier le premier patron</button></a>
        </div>
    <?php else: ?>
        <div class="masonry-grid">
            <?php foreach ($patrons as $patron): ?>
                <a href="patron.php?id=<?= $patron['id'] ?>" class="patron-pin">
                    <?php if (!empty($patron['tags'])): ?>
                        <div class="pin-badge">
                            <span class="chip"><?= htmlspecialchars(trim(explode(',', $patron['tags'])[0])) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="pin-heart">♥</div>
                    <canvas class="pin-canvas"
                            data-grille="<?= htmlspecialchars($patron['grille_json']) ?>">
                    </canvas>
                    <div class="pin-footer">
                        <div class="pin-footer-top">
                            <h3 class="pin-titre"><?= htmlspecialchars($patron['titre']) ?></h3>
                            <span class="pin-likes">♥ <?= $patron['nb_likes'] ?></span>
                        </div>
                        <p class="pin-auteur">par @<?= htmlspecialchars($patron['auteur']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

<script>
// Canvas flottant vedette
const vf = document.getElementById('canvas-float');
if (vf) {
    try {
        const c = JSON.parse(vf.dataset.grille).couleurs;
        const r = c.length, col = c[0].length;
        const ctx = vf.getContext('2d');
        const cell = Math.floor(48 / Math.max(r, col));
        vf.width = col * cell; vf.height = r * cell;
        c.forEach((row, i) => row.forEach((color, j) => {
            ctx.fillStyle = color;
            ctx.fillRect(j * cell, i * cell, cell, cell);
        }));
    } catch(e) {}
}

// Canvas grille patrons
document.querySelectorAll('.pin-canvas').forEach(canvas => {
    try {
        const c = JSON.parse(canvas.dataset.grille).couleurs;
        const r = c.length, col = c[0].length;
        const ctx = canvas.getContext('2d');
        const cell = Math.min(10, Math.floor(300 / col));
        canvas.width = col * cell; canvas.height = r * cell;
        c.forEach((row, i) => row.forEach((color, j) => {
            ctx.fillStyle = color;
            ctx.fillRect(j * cell, i * cell, cell, cell);
        }));
    } catch(e) {}
});
</script>

</body>
</html>
