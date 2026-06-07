<?php
session_start();
require_once 'bd.php';

$query = trim($_GET['q'] ?? '');
$motif = '%' . $query . '%';

if ($query !== '') {
    $stmt = $pdo->prepare("
        SELECT patrons.id, patrons.titre, patrons.grille_json,
               patrons.created_at, patrons.tags, patrons.description,
               users.pseudo AS auteur, users.id AS user_id, users.pp AS auteur_pp,
               COUNT(likes.patron_id) AS nb_likes
        FROM patrons
        LEFT JOIN users ON patrons.user_id = users.id
        LEFT JOIN likes ON patrons.id = likes.patron_id
        WHERE LOWER(patrons.titre) LIKE LOWER(?)
           OR LOWER(patrons.tags)  LIKE LOWER(?)
           OR LOWER(users.pseudo)  LIKE LOWER(?)
        GROUP BY patrons.id
        ORDER BY patrons.created_at DESC
    ");
    $stmt->execute([$motif, $motif, $motif]);
} else {
    $stmt = $pdo->query("
        SELECT patrons.id, patrons.titre, patrons.grille_json,
               patrons.created_at, patrons.tags, patrons.description,
               users.pseudo AS auteur, users.id AS user_id, users.pp AS auteur_pp,
               COUNT(likes.patron_id) AS nb_likes
        FROM patrons
        LEFT JOIN users ON patrons.user_id = users.id
        LEFT JOIN likes ON patrons.id = likes.patron_id
        GROUP BY patrons.id
        ORDER BY patrons.created_at DESC
    ");
}
$patrons = $stmt->fetchAll();

$users = [];
if ($query !== '') {
    $stmt2 = $pdo->prepare("SELECT id, pseudo, pp, (SELECT COUNT(*) FROM patrons WHERE patrons.user_id = users.id) AS nb_patrons FROM users WHERE LOWER(pseudo) LIKE LOWER(?) LIMIT 6");
    $stmt2->execute([$motif]);
    $users = $stmt2->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $query ? htmlspecialchars($query).' — ' : '' ?>Explorer — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div style="max-width:1400px;margin:0 auto;padding:40px 32px 80px;">

    <!-- En-tête minimal -->
    <div style="margin-bottom:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-family:'Fraunces',serif;font-size:36px;font-weight:900;letter-spacing:-0.02em;line-height:1;">
                <?= $query
                    ? '<em style="font-style:italic;background:var(--lime);padding:0 8px;border-radius:6px;">'.htmlspecialchars($query).'</em>'
                    : 'Explorer' ?>
            </h1>
            <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--muted);margin-top:4px;">
                <?= count($patrons) ?> création<?= count($patrons)>1?'s':'' ?>
            </p>
        </div>
        <?php if ($query): ?>
            <a href="recherche.php" style="font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;color:var(--mid);text-decoration:underline;text-underline-offset:3px;">
                ← Tout voir
            </a>
        <?php endif; ?>
    </div>

    <!-- Créateurs trouvés -->
    <?php if (!empty($users)): ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px;">
        <?php foreach ($users as $u): ?>
        <a href="profil.php?id=<?= $u['id'] ?>"
           style="display:flex;align-items:center;gap:8px;background:var(--white);border:1.5px solid var(--border-col);border-radius:999px;padding:6px 14px 6px 6px;color:var(--dark);transition:border-color .15s;"
           onmouseover="this.style.borderColor='var(--lime)'"
           onmouseout="this.style.borderColor='var(--border-col)'">
            <?php if (!empty($u['pp'])): ?>
                <img src="<?= htmlspecialchars($u['pp']) ?>" style="width:28px;height:28px;border-radius:50%;object-fit:cover;" alt="Photo de profil de <?= htmlspecialchars($u['pseudo']) ?>">
            <?php else: ?>
                <div style="width:28px;height:28px;border-radius:50%;background:var(--lime);display:flex;align-items:center;justify-content:center;font-family:'Fraunces',serif;font-size:12px;font-weight:700;color:var(--dark);"><?= strtoupper(mb_substr($u['pseudo'],0,1)) ?></div>
            <?php endif; ?>
            <span style="font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;">@<?= htmlspecialchars($u['pseudo']) ?></span>
            <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:var(--muted);"><?= $u['nb_patrons'] ?> patron<?= $u['nb_patrons']>1?'s':'' ?></span>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Grille Pinterest -->
    <?php if (empty($patrons)): ?>
        <div class="empty-state">
            <p>Aucun résultat pour « <?= htmlspecialchars($query) ?> »</p>
            <a href="recherche.php"><button class="btn-secondary">Voir toutes les créations</button></a>
        </div>
    <?php else: ?>
        <div class="pinterest-grid" id="pinterest-grid">
            <?php foreach ($patrons as $p): ?>
            <a href="patron.php?id=<?= $p['id'] ?>" class="pin">
                <?php if (!empty($p['tags'])): ?>
                    <div class="pin-tag">
                        <span class="chip" style="font-size:10px;padding:3px 10px;"><?= htmlspecialchars(trim(explode(',',$p['tags'])[0])) ?></span>
                    </div>
                <?php endif; ?>
                <div class="pin-like">
                    ♥ <?= $p['nb_likes'] ?>
                </div>
                <div class="pin-canvas-wrap">
                    <canvas data-grille="<?= htmlspecialchars($p['grille_json']) ?>"></canvas>
                </div>
                <div class="pin-info">
                    <p class="pin-title"><?= htmlspecialchars($p['titre']) ?></p>
                    <?php if (!empty($p['description'])): ?>
                        <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--mid);font-weight:300;line-height:1.5;margin:0;"><?= htmlspecialchars(mb_substr($p['description'],0,80)) . (mb_strlen($p['description'])>80?'…':'') ?></p>
                    <?php endif; ?>
                    <div class="pin-author">
                        <?php if (!empty($p['auteur_pp'])): ?>
                            <img src="<?= htmlspecialchars($p['auteur_pp']) ?>" alt="Photo de profil de <?= htmlspecialchars($p['auteur']) ?>">
                        <?php else: ?>
                            <div class="pin-author-av"><?= strtoupper(mb_substr($p['auteur'],0,1)) ?></div>
                        <?php endif; ?>
                        <span>@<?= htmlspecialchars($p['auteur']) ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

<script>
document.querySelectorAll('.pin-canvas-wrap canvas').forEach(canvas => {
    try {
        const data = JSON.parse(canvas.dataset.grille);
        const c = data.couleurs;
        const rows = c.length, cols = c[0].length;
        const ctx = canvas.getContext('2d');
        // Taille de cellule adaptée à la colonne (~280px / cols)
        const cell = Math.max(3, Math.min(12, Math.floor(280 / cols)));
        canvas.width  = cols * cell;
        canvas.height = rows * cell;
        c.forEach((row, i) => row.forEach((color, j) => {
            ctx.fillStyle = color;
            ctx.fillRect(j*cell, i*cell, cell, cell);
        }));
    } catch(e) {}
});
</script>
</body>
</html>
