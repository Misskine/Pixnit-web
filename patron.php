<?php
session_start();
require_once 'bd.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) { http_response_code(400); die("Patron introuvable."); }

$erreur_com = '';

if (isset($_POST['submit_commentaire'])) {
    if (!isset($_SESSION['user_id'])) { header("Location: connexion.php"); exit(); }
    $contenu = trim($_POST['contenu']);
    if (empty($contenu)) {
        $erreur_com = "Le commentaire ne peut pas être vide.";
    } elseif (strlen($contenu) > 1000) {
        $erreur_com = "Le commentaire est trop long (max 1000 caractères).";
    } else {
        $s = $pdo->prepare("INSERT INTO commentaires (user_id, patron_id, contenu) VALUES (?,?,?)");
        $s->execute([$_SESSION['user_id'], $id, $contenu]);
        header("Location: patron.php?id=$id"); exit();
    }
}

$stmt = $pdo->prepare("
    SELECT patrons.*, users.pseudo AS auteur, users.pp AS auteur_pp,
           COUNT(likes.patron_id) AS nb_likes
    FROM patrons
    LEFT JOIN users ON patrons.user_id = users.id
    LEFT JOIN likes ON patrons.id = likes.patron_id
    WHERE patrons.id = ?
    GROUP BY patrons.id
");
$stmt->execute([$id]);
$patron = $stmt->fetch();
if (!$patron) { http_response_code(404); die("Patron introuvable."); }

$stmt2 = $pdo->prepare("
    SELECT commentaires.*, users.pseudo AS auteur, users.id AS user_id, users.pp AS auteur_pp
    FROM commentaires
    LEFT JOIN users ON commentaires.user_id = users.id
    WHERE commentaires.patron_id = ?
    ORDER BY commentaires.created_at ASC
");
$stmt2->execute([$id]);
$commentaires = $stmt2->fetchAll();

$deja_like = false;
if (isset($_SESSION['user_id'])) {
    $s = $pdo->prepare("SELECT 1 FROM likes WHERE user_id = ? AND patron_id = ?");
    $s->execute([$_SESSION['user_id'], $id]);
    $deja_like = (bool) $s->fetch();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($patron['titre']) ?> — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="page-wrapper">

    <!-- Fil d'ariane -->
    <p class="pixel-label">
        <a href="index.php">Accueil</a> · <?= htmlspecialchars($patron['titre']) ?>
    </p>

    <!-- ═══ HERO : canvas + infos ═══════════════════════ -->
    <div class="patron-hero">

        <!-- Gauche : canvas -->
        <div class="patron-canvas-wrap">
            <canvas id="canvas-patron"
                    data-grille="<?= htmlspecialchars($patron['grille_json']) ?>">
            </canvas>
        </div>

        <!-- Droite : infos -->
        <div class="patron-info-col">

            <!-- Tags -->
            <?php if (!empty($patron['tags'])): ?>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <?php foreach (explode(',', $patron['tags']) as $tag): ?>
                        <span class="chip"><?= htmlspecialchars(trim($tag)) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Titre -->
            <h1 class="patron-titre-main"><?= htmlspecialchars($patron['titre']) ?></h1>

            <!-- Description -->
            <?php if (!empty($patron['description'])): ?>
                <p class="patron-desc-main">
                    <?= nl2br(htmlspecialchars($patron['description'])) ?>
                </p>
            <?php endif; ?>

            <!-- ══ Stats calculées depuis la grille ══ -->
            <div class="stats-row">
                <div class="stat-block">
                    <span class="stat-val" id="stat-grille">—</span>
                    <span class="stat-lbl">grille</span>
                </div>
                <div class="stat-block">
                    <div id="stat-couleurs-swatches" style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:4px;min-height:16px;"></div>
                    <span class="stat-val" id="stat-couleurs">—</span>
                    <span class="stat-lbl">couleurs</span>
                </div>
                <div class="stat-block">
                    <?php
                    $diffMap = ['Débutant'=>1,'Intermédiaire'=>2,'Avancé'=>3,'Expert'=>4];
                    $diffNb  = $diffMap[$patron['difficulte'] ?? ''] ?? 0;
                    ?>
                    <div style="display:flex;gap:3px;align-items:center;margin-bottom:4px;min-height:16px;">
                        <?php for($i=1;$i<=4;$i++): ?>
                            <img src="assets/staricon.jpg" alt="" class="diff-star<?= $i > $diffNb ? ' off' : '' ?>">
                        <?php endfor; ?>
                    </div>
                    <span class="stat-val"><?= htmlspecialchars($patron['difficulte'] ?? '—') ?></span>
                    <span class="stat-lbl">difficulté</span>
                </div>
                <div class="stat-block">
                    <span class="stat-val"><?= htmlspecialchars($patron['temps'] ?? '—') ?></span>
                    <span class="stat-lbl">temps est.</span>
                </div>
            </div>

            <!-- Carte auteur -->
            <div class="auteur-card">
                <?php if (!empty($patron['auteur_pp'])): ?>
                    <img src="<?= htmlspecialchars($patron['auteur_pp']) ?>"
                         alt="<?= htmlspecialchars($patron['auteur']) ?>"
                         style="width:44px;height:44px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid var(--border-col);">
                <?php else: ?>
                    <div class="avatar"><?= strtoupper(mb_substr($patron['auteur'], 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <p class="pixel-label" style="margin-bottom:3px;">patron par</p>
                    <a href="profil.php?id=<?= $patron['user_id'] ?>"
                       style="font-weight:700; font-size:15px;">
                        @<?= htmlspecialchars($patron['auteur']) ?>
                    </a>
                </div>
            </div>

            <!-- Likes + téléchargements -->
            <div style="display:flex;flex-direction:column;gap:14px;">

                <!-- Like -->
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button id="btn-like"
                                class="<?= $deja_like ? 'btn-liked' : '' ?>"
                                data-patron-id="<?= $patron['id'] ?>"
                                style="display:flex;align-items:center;gap:7px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="<?= $deja_like ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            <span id="nb-likes"><?= $patron['nb_likes'] ?></span>
                            <?= $deja_like ? 'Aimé' : 'Aimer' ?>
                        </button>
                    <?php else: ?>
                        <a href="connexion.php">
                            <button style="display:flex;align-items:center;gap:7px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                <?= $patron['nb_likes'] ?> Aimer
                            </button>
                        </a>
                    <?php endif; ?>
                    <p class="pixel-label" style="margin:0;">Publié le <?= date("d/m/Y", strtotime($patron['created_at'])) ?></p>
                </div>

                <!-- Téléchargement -->
                <div style="position:relative;display:inline-block;">
                    <button id="btn-dl-toggle" class="btn-secondary" style="font-size:13px;padding:11px 22px;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Télécharger
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="dl-menu" style="display:none;position:absolute;top:calc(100% + 6px);left:0;background:var(--white);border:1.5px solid var(--border-col);border-radius:14px;padding:6px;min-width:140px;box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:50;">
                        <button id="btn-dl-json" style="width:100%;text-align:left;background:none;border:none;border-radius:8px;padding:9px 14px;font-size:13px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;align-items:center;gap:8px;letter-spacing:0;text-transform:none;box-shadow:none;" onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='none'">JSON</button>
                        <button id="btn-dl-png" style="width:100%;text-align:left;background:none;border:none;border-radius:8px;padding:9px 14px;font-size:13px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;align-items:center;gap:8px;letter-spacing:0;text-transform:none;box-shadow:none;" onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='none'">PNG</button>
                        <button id="btn-dl-pdf" style="width:100%;text-align:left;background:none;border:none;border-radius:8px;padding:9px 14px;font-size:13px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;align-items:center;gap:8px;letter-spacing:0;text-transform:none;box-shadow:none;" onmouseover="this.style.background='var(--cream)'" onmouseout="this.style.background='none'">PDF</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <hr class="hr-dashed">

    <!-- ═══ COMMENTAIRES ════════════════════════════════ -->
    <div class="comments-section">

        <h2 style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;letter-spacing:-0.01em;margin-bottom:20px;">
            Commentaires
            <span class="section-subtitle" style="margin-left:8px;">
                <?= count($commentaires) ?>
            </span>
        </h2>

        <!-- Formulaire -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($erreur_com): ?>
                <p class="erreur" style="margin-bottom:12px;"><?= htmlspecialchars($erreur_com) ?></p>
            <?php endif; ?>
            <form method="POST" action="patron.php?id=<?= $id ?>"
                  class="comment-form" style="display:flex;gap:12px;align-items:flex-start;">
                <?php if (!empty($_SESSION['pp'])): ?>
                    <img src="<?= htmlspecialchars($_SESSION['pp']) ?>"
                         alt="<?= htmlspecialchars($_SESSION['pseudo']) ?>"
                         style="width:40px;height:40px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid var(--border-col);margin-top:2px;">
                <?php else: ?>
                    <div class="avatar" style="width:40px;height:40px;font-size:16px;flex-shrink:0;margin-top:2px;">
                        <?= strtoupper(mb_substr($_SESSION['pseudo'], 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <div style="flex:1;display:flex;flex-direction:column;gap:10px;">
                    <textarea name="contenu"
                              placeholder="Laisse un commentaire…"
                              maxlength="1000" required></textarea>
                    <button type="submit" name="submit_commentaire" style="align-self:flex-start;">Publier</button>
                </div>
            </form>
        <?php else: ?>
            <p style="margin-bottom:20px;">
                <a href="connexion.php" style="font-weight:700;text-decoration:underline;text-underline-offset:3px;">
                    Connecte-toi
                </a>
                pour laisser un commentaire.
            </p>
        <?php endif; ?>

        <!-- Liste des commentaires -->
        <?php if (empty($commentaires)): ?>
            <p style="color:var(--muted); font-weight:300; font-style:italic;">
                Aucun commentaire pour l'instant. Sois le·la premier·ère !
            </p>
        <?php else: ?>
            <div class="comment-list">
                <?php foreach ($commentaires as $com): ?>
                    <div class="comment-card">
                        <?php if (!empty($com['auteur_pp'])): ?>
                            <img src="<?= htmlspecialchars($com['auteur_pp']) ?>"
                                 alt="<?= htmlspecialchars($com['auteur']) ?>"
                                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid var(--border-col);">
                        <?php else: ?>
                            <div class="avatar" style="width:36px;height:36px;font-size:14px;flex-shrink:0;">
                                <?= strtoupper(mb_substr($com['auteur'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                                <a href="profil.php?id=<?= $com['user_id'] ?>"
                                   style="font-weight:700; font-size:14px;">
                                    @<?= htmlspecialchars($com['auteur']) ?>
                                </a>
                                <span class="pixel-label">
                                    <?= date('d/m/Y', strtotime($com['created_at'])) ?>
                                </span>
                            </div>
                            <p style="font-size:14px; line-height:1.6; color:var(--dark);">
                                <?= nl2br(htmlspecialchars($com['contenu'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</div>

<?php include 'footer.php'; ?>

<script>
// Canvas principal
const canvas = document.getElementById('canvas-patron');
if (canvas) {
    const c = JSON.parse(canvas.dataset.grille).couleurs;
    const rows = c.length, cols = c[0].length;
    const ctx = canvas.getContext('2d');
    const cell = Math.min(14, Math.floor(500 / Math.max(rows, cols)));
    canvas.width = cols * cell; canvas.height = rows * cell;
    c.forEach((row, i) => row.forEach((color, j) => {
        ctx.fillStyle = color;
        ctx.fillRect(j * cell, i * cell, cell, cell);
    }));
}

// ── Like ─────────────────────────────────────────────
const btnLike = document.getElementById('btn-like');
if (btnLike) {
    btnLike.addEventListener('click', () => {
        fetch('like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'patron_id=' + btnLike.dataset.patronId
        })
        .then(r => r.json())
        .then(data => {
            const liked = data.action === 'like';
            const nb    = data.nb_likes;
            btnLike.classList.toggle('btn-liked', liked);
            const heartFill = liked ? 'currentColor' : 'none';
            btnLike.innerHTML = `
                <svg width="14" height="14" viewBox="0 0 24 24" fill="${heartFill}" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span id="nb-likes">${nb}</span> ${liked ? 'Aimé' : 'Aimer'}
            `;
        })
        .catch(err => console.error(err));
    });
}

// ── Compteurs ─────────────────────────────────────────
(function() {
    const grille = JSON.parse(<?= json_encode($patron['grille_json']) ?>);
    const couleurs = grille.couleurs;
    const rows = couleurs.length;
    const cols = couleurs[0]?.length ?? 0;
    const stitches = rows * cols;

    // Taille grille
    document.getElementById('stat-grille').textContent = rows + '×' + cols;

    // Groupement par famille HSL (rouge, orange, jaune, vert, bleu, violet, neutre)
    function rgbToHsl(r, g, b) {
        r /= 255; g /= 255; b /= 255;
        const max = Math.max(r,g,b), min = Math.min(r,g,b);
        let h, s, l = (max+min)/2;
        if (max === min) { h = s = 0; }
        else {
            const d = max - min;
            s = l > 0.5 ? d/(2-max-min) : d/(max+min);
            switch(max) {
                case r: h = ((g-b)/d + (g<b?6:0))/6; break;
                case g: h = ((b-r)/d + 2)/6; break;
                case b: h = ((r-g)/d + 4)/6; break;
            }
        }
        return [h*360, s, l];
    }

    function colorFamily(hex) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        const [h, s, l] = rgbToHsl(r, g, b);
        // Neutres : faible saturation ou extrêmes de luminosité
        if (s < 0.15 || l < 0.10) return l < 0.35 ? 'noir' : l > 0.80 ? 'blanc' : 'gris';
        // Familles de teinte (8 secteurs)
        if (h < 22 || h >= 345) return 'rouge';
        if (h < 45)  return 'orange';
        if (h < 70)  return 'jaune';
        if (h < 150) return 'vert';
        if (h < 195) return 'cyan';
        if (h < 255) return 'bleu';
        if (h < 300) return 'violet';
        return 'rose';
    }

    // Agréger par famille
    const buckets = {};
    couleurs.forEach(row => row.forEach(hex => {
        if (!hex || hex === 'transparent' || hex.length < 7) return;
        const fam = colorFamily(hex);
        if (!buckets[fam]) buckets[fam] = { count: 0, r: 0, g: 0, b: 0 };
        buckets[fam].count++;
        buckets[fam].r += parseInt(hex.slice(1,3),16);
        buckets[fam].g += parseInt(hex.slice(3,5),16);
        buckets[fam].b += parseInt(hex.slice(5,7),16);
    }));

    // Couleur moyenne par famille
    const uniqueColors = Object.values(buckets)
        .sort((a,b) => b.count - a.count)
        .map(b => '#' + [b.r/b.count, b.g/b.count, b.b/b.count]
            .map(v => Math.round(v).toString(16).padStart(2,'0')).join(''));

    const nbCouleurs = Object.keys(buckets).length;
    document.getElementById('stat-couleurs').textContent = nbCouleurs;

    const swatchWrap = document.getElementById('stat-couleurs-swatches');
    uniqueColors.forEach(c => {
        const s = document.createElement('span');
        s.className = 'color-swatch';
        s.style.background = c;
        swatchWrap.appendChild(s);
    });

    // Difficulté et temps : valeurs définies par l'auteur (affichées côté PHP)
})();

// ── Menu téléchargement ───────────────────────────────
const dlToggle = document.getElementById('btn-dl-toggle');
const dlMenu   = document.getElementById('dl-menu');
if (dlToggle && dlMenu) {
    dlToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        dlMenu.style.display = dlMenu.style.display === 'none' ? 'block' : 'none';
    });
    document.addEventListener('click', () => { dlMenu.style.display = 'none'; });
}

// ── Téléchargements ───────────────────────────────────
const patronTitre = <?= json_encode($patron['titre']) ?>;
const grilleJson  = <?= json_encode($patron['grille_json']) ?>;
const cvs         = document.getElementById('canvas-patron');

function trackDownload(patronId) {
    fetch('telecharger.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'patron_id=' + patronId
    }).catch(() => {});
}
const patronId = <?= $patron['id'] ?>;

// JSON
document.getElementById('btn-dl-json')?.addEventListener('click', () => {
    trackDownload(patronId);
    const blob = new Blob([grilleJson], { type: 'application/json' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = patronTitre.replace(/\s+/g, '_') + '.json';
    a.click();
});

// PNG — canvas haute résolution
document.getElementById('btn-dl-png')?.addEventListener('click', () => {
    trackDownload(patronId);
    if (!cvs) return;
    const data   = JSON.parse(grilleJson).couleurs;
    const rows   = data.length, cols = data[0].length;
    const cell   = 20; // 20px par maille pour un PNG net
    const tmpCvs = document.createElement('canvas');
    tmpCvs.width  = cols * cell;
    tmpCvs.height = rows * cell;
    const ctx = tmpCvs.getContext('2d');
    data.forEach((row, i) => row.forEach((color, j) => {
        ctx.fillStyle = color;
        ctx.fillRect(j * cell, i * cell, cell, cell);
    }));
    const a = document.createElement('a');
    a.href = tmpCvs.toDataURL('image/png');
    a.download = patronTitre.replace(/\s+/g, '_') + '.png';
    a.click();
});

// PDF — canvas → jsPDF
document.getElementById('btn-dl-pdf')?.addEventListener('click', async () => {
    trackDownload(patronId);
    if (!cvs) return;
    // Charge jsPDF à la volée
    if (!window.jspdf) {
        await new Promise((resolve, reject) => {
            const s = document.createElement('script');
            s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
            s.onload = resolve; s.onerror = reject;
            document.head.appendChild(s);
        });
    }
    const { jsPDF } = window.jspdf;
    const data   = JSON.parse(grilleJson).couleurs;
    const rows   = data.length, cols = data[0].length;
    const cell   = 20;
    const tmpCvs = document.createElement('canvas');
    tmpCvs.width  = cols * cell;
    tmpCvs.height = rows * cell;
    const ctx = tmpCvs.getContext('2d');
    data.forEach((row, i) => row.forEach((color, j) => {
        ctx.fillStyle = color;
        ctx.fillRect(j * cell, i * cell, cell, cell);
    }));
    const imgData = tmpCvs.toDataURL('image/png');
    const pxToMm  = 0.264583;
    const wMm = cols * cell * pxToMm;
    const hMm = rows * cell * pxToMm;
    const doc = new jsPDF({ orientation: wMm > hMm ? 'landscape' : 'portrait', unit: 'mm', format: [wMm + 20, hMm + 30] });
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(14);
    doc.text(patronTitre, 10, 12);
    doc.setFontSize(9);
    doc.setTextColor(120);
    doc.text('pixknit.', 10, 20);
    doc.addImage(imgData, 'PNG', 10, 26, wMm, hMm);
    doc.save(patronTitre.replace(/\s+/g, '_') + '.pdf');
});
</script>

</body>
</html>
