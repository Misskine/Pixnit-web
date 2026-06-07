<?php
session_start();
require_once 'bd.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) { http_response_code(400); die("Utilisateur introuvable."); }

$stmt = $pdo->prepare("SELECT id, pseudo, pp, created_at FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) { http_response_code(404); die("Profil introuvable."); }

$est_mon_profil = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$user['id'];
$erreur = '';
$succes = isset($_GET['succes']) ? "Photo de profil mise à jour !" : '';

// ── Upload photo de profil ──────────────────────────────
if ($est_mon_profil && isset($_POST['upload_pp'])) {

    if (empty($_FILES['pp']['name'])) {
        $erreur = "Aucun fichier sélectionné.";
    } else {
        $file   = $_FILES['pp'];
        $ext    = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allow  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxSize = 3 * 1024 * 1024; // 3 Mo

        if (!in_array($ext, $allow)) {
            $erreur = "Format non accepté (jpg, png, gif, webp).";
        } elseif ($file['size'] > $maxSize) {
            $erreur = "Image trop lourde (max 3 Mo).";
        } else {
            // Vérifier que c'est vraiment une image
            $info = getimagesize($file['tmp_name']);
            if (!$info) {
                $erreur = "Fichier invalide.";
            } else {
                // Créer le dossier si besoin
                if (!is_dir('uploads/avatars')) {
                    mkdir('uploads/avatars', 0755, true);
                }
                // Supprimer l'ancienne photo
                if (!empty($user['pp']) && file_exists($user['pp'])) {
                    unlink($user['pp']);
                }
                // Sauvegarder la nouvelle
                $nom = 'uploads/avatars/user_' . $id . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($file['tmp_name'], $nom);

                // Mettre à jour la BDD
                $s = $pdo->prepare("UPDATE users SET pp = ? WHERE id = ?");
                $s->execute([$nom, $id]);

                // Mettre à jour la session et rediriger
                $_SESSION['pp'] = $nom;
                header("Location: profil.php?id=" . $id . "&succes=1");
                exit();
            }
        }
    }
}

// ── Ajouter colonne si manquante ───────────────────────
try { $pdo->exec("ALTER TABLE patrons ADD COLUMN nb_telechargements INT DEFAULT 0"); } catch (Exception $e) {}

// ── Patrons de l'utilisateur ────────────────────────────
$stmt2 = $pdo->prepare("
    SELECT patrons.*, COUNT(likes.patron_id) AS nb_likes
    FROM patrons
    LEFT JOIN likes ON patrons.id = likes.patron_id
    WHERE patrons.user_id = ?
    GROUP BY patrons.id
    ORDER BY patrons.created_at DESC
");
$stmt2->execute([$id]);
$patrons = $stmt2->fetchAll();

// ── Totaux likes + téléchargements ─────────────────────
$stmt3 = $pdo->prepare("
    SELECT
        COALESCE(SUM(nb_telechargements), 0) AS total_dl,
        COALESCE((SELECT COUNT(*) FROM likes WHERE likes.patron_id IN (SELECT id FROM patrons WHERE user_id = ?)), 0) AS total_likes
    FROM patrons WHERE user_id = ?
");
$stmt3->execute([$id, $id]);
$stats = $stmt3->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@<?= htmlspecialchars($user['pseudo']) ?> — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="page-wrapper">

    <!-- ── En-tête profil ─────────────────────────────── -->
    <div class="profil-header">

        <!-- Avatar (photo ou initiale) -->
        <div class="profil-avatar-wrap">
            <?php if (!empty($user['pp'])): ?>
                <img src="<?= htmlspecialchars($user['pp']) ?>"
                     alt="@<?= htmlspecialchars($user['pseudo']) ?>"
                     class="profil-avatar-img">
            <?php else: ?>
                <div class="profil-avatar">
                    <?= strtoupper(mb_substr($user['pseudo'], 0, 1)) ?>
                </div>
            <?php endif; ?>

            <!-- Bouton changer la photo (seulement sur son propre profil) -->
            <?php if ($est_mon_profil): ?>
                <label for="input-pp" class="btn-changer-pp" title="Changer la photo">
                    ✎
                </label>
            <?php endif; ?>
        </div>

        <!-- Infos -->
        <div style="flex:1;">
            <h1 class="profil-name">@<?= htmlspecialchars($user['pseudo']) ?></h1>
            <p class="profil-meta">membre depuis <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>

            <!-- Compteurs -->
            <div style="display:flex;gap:20px;margin-top:16px;flex-wrap:wrap;">
                <div style="display:flex;flex-direction:column;gap:2px;">
                    <span style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;line-height:1;color:var(--dark);"><?= count($patrons) ?></span>
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);">patron<?= count($patrons) > 1 ? 's' : '' ?></span>
                </div>
                <div style="width:1px;background:var(--border-col);"></div>
                <div style="display:flex;flex-direction:column;gap:2px;">
                    <span style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;line-height:1;color:var(--dark);"><?= (int)$stats['total_likes'] ?></span>
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);">j'aime reçus</span>
                </div>
                <div style="width:1px;background:var(--border-col);"></div>
                <div style="display:flex;flex-direction:column;gap:2px;">
                    <span style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;line-height:1;color:var(--dark);"><?= (int)$stats['total_dl'] ?></span>
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);">téléchargements</span>
                </div>
            </div>

            <!-- Messages -->
            <?php if ($erreur): ?>
                <p class="erreur" style="margin-top:10px;"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>
            <?php if ($succes): ?>
                <p class="succes" style="margin-top:10px;"><?= htmlspecialchars($succes) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($est_mon_profil): ?>
            <a href="deconnexion.php">
                <button class="btn-secondary" style="font-size:11px; padding:9px 20px;">
                    Déconnexion
                </button>
            </a>
        <?php endif; ?>

    </div>

    <!-- Formulaire upload photo (caché, déclenché par le bouton ✎) -->
    <?php if ($est_mon_profil): ?>
        <form method="POST" action="profil.php?id=<?= $id ?>"
              enctype="multipart/form-data" id="form-pp">
            <input type="file" id="input-pp" name="pp"
                   accept="image/jpeg,image/png,image/gif,image/webp"
                   style="display:none;">
            <input type="hidden" name="upload_pp" value="1">
        </form>
        <script>
        // Soumettre automatiquement quand un fichier est choisi
        document.getElementById('input-pp').addEventListener('change', function () {
            if (this.files.length) document.getElementById('form-pp').submit();
        });
        </script>
    <?php endif; ?>

    <!-- ── Grille des patrons ─────────────────────────── -->
    <div style="display:flex; align-items:baseline; gap:12px;">
        <h2 class="section-title">Patrons</h2>
        <span class="section-subtitle"><?= count($patrons) ?></span>
    </div>

    <?php if (empty($patrons)): ?>
        <div class="empty-state">
            <p>Aucun patron publié pour l'instant.</p>
            <?php if ($est_mon_profil): ?>
                <a href="upload.php"><button>+ Publier mon premier patron</button></a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="masonry-grid">
            <?php foreach ($patrons as $patron): ?>
                <a href="patron.php?id=<?= $patron['id'] ?>" class="patron-pin">
                    <div class="pin-heart">⊙</div>
                    <canvas class="pin-canvas"
                            data-grille="<?= htmlspecialchars($patron['grille_json']) ?>">
                    </canvas>
                    <div class="pin-footer">
                        <div class="pin-footer-top">
                            <h3 class="pin-titre"><?= htmlspecialchars($patron['titre']) ?></h3>
                            <div style="display:flex;gap:8px;align-items:center;flex-shrink:0;">
                                <span class="pin-likes">♥ <?= $patron['nb_likes'] ?></span>
                                <span class="pin-likes" title="téléchargements">↓ <?= (int)($patron['nb_telechargements'] ?? 0) ?></span>
                            </div>
                        </div>
                        <p class="pin-auteur"><?= date('d/m/Y', strtotime($patron['created_at'])) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>

<script>
document.querySelectorAll('.pin-canvas').forEach(canvas => {
    const c = JSON.parse(canvas.dataset.grille).couleurs;
    const rows = c.length, cols = c[0].length;
    const ctx = canvas.getContext('2d');
    const cell = Math.min(10, Math.floor(300 / cols));
    canvas.width = cols * cell; canvas.height = rows * cell;
    c.forEach((row, i) => row.forEach((color, j) => {
        ctx.fillStyle = color;
        ctx.fillRect(j * cell, i * cell, cell, cell);
    }));
});
</script>

</body>
</html>
