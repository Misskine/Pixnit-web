<?php
session_start();
require_once 'bd.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Ajouter colonnes si manquantes
try { $pdo->exec("ALTER TABLE patrons ADD COLUMN difficulte VARCHAR(30) DEFAULT NULL"); } catch(Exception $e){}
try { $pdo->exec("ALTER TABLE patrons ADD COLUMN temps VARCHAR(30) DEFAULT NULL"); } catch(Exception $e){}

$erreur      = '';
$titre       = '';
$description = '';
$tags        = '';
$difficulte  = '';
$temps       = '';

if (isset($_POST['submit'])) {
    $titre       = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $tags        = trim($_POST['tags']);
    $difficulte  = trim($_POST['difficulte'] ?? '');
    $temps       = trim($_POST['temps'] ?? '');

    if (empty($titre)) {
        $erreur = "Le titre est obligatoire.";
    } elseif (!isset($_FILES['json_file']) || $_FILES['json_file']['error'] !== UPLOAD_ERR_OK) {
        $erreur = "Veuillez télécharger un fichier JSON valide.";
    } else {
        $extension = pathinfo($_FILES['json_file']['name'], PATHINFO_EXTENSION);
        if ($extension !== 'json') {
            $erreur = "Le fichier doit être au format .json.";
        } else {
            $contenu = file_get_contents($_FILES['json_file']['tmp_name']);
            $data    = json_decode($contenu, true);

            if ($data === null || !isset($data['couleurs']) || empty($data['couleurs'])) {
                $erreur = "JSON invalide — il doit contenir une clé 'couleurs' avec un tableau 2D.";
            } else {
                $grille_json = json_encode($data);
                $stmt = $pdo->prepare("
                    INSERT INTO patrons (user_id, titre, description, grille_json, tags, difficulte, temps)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$_SESSION['user_id'], $titre, $description, $grille_json, $tags, $difficulte ?: null, $temps ?: null]);
                header("Location: patron.php?id=" . $pdo->lastInsertId());
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Publier un patron — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body class="upload-page">

<?php include 'header.php'; ?>

<div class="form-card" style="max-width:560px;background:rgba(255,255,255,0.95);backdrop-filter:blur(8px);box-shadow:0 8px 48px rgba(0,0,0,.12);">
    <h1>Publier un patron</h1>

    <?php if ($erreur): ?>
        <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <div>
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre"
                   value="<?= htmlspecialchars($titre) ?>"
                   placeholder="Ex : Champignon kawaii">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"
                      rows="3"><?= htmlspecialchars($description) ?></textarea>
        </div>
        <div>
            <label for="tags">Tags <span style="font-family:var(--font-main); text-transform:none; font-size:12px; color:var(--muted);">(séparés par des virgules)</span></label>
            <input type="text" id="tags" name="tags"
                   value="<?= htmlspecialchars($tags) ?>"
                   placeholder="champignon, kawaii, nature">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label for="difficulte">Difficulté</label>
                <select id="difficulte" name="difficulte" style="width:100%;padding:13px 20px;border:1.5px solid rgba(0,0,0,.12);border-radius:999px;font-family:'DM Sans',sans-serif;font-size:15px;background:var(--cream);color:var(--dark);outline:none;appearance:none;cursor:pointer;">
                    <option value="" <?= !$difficulte ? 'selected' : '' ?>>— choisir</option>
                    <option value="Débutant"      <?= $difficulte==='Débutant'      ? 'selected' : '' ?>>Débutant</option>
                    <option value="Intermédiaire" <?= $difficulte==='Intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
                    <option value="Avancé"        <?= $difficulte==='Avancé'        ? 'selected' : '' ?>>Avancé</option>
                    <option value="Expert"        <?= $difficulte==='Expert'        ? 'selected' : '' ?>>Expert</option>
                </select>
            </div>
            <div>
                <label for="temps">Temps estimé</label>
                <input type="text" id="temps" name="temps"
                       value="<?= htmlspecialchars($temps) ?>"
                       placeholder="ex : 2h30">
            </div>
        </div>
        <div>
            <label for="json_file">Fichier JSON *</label>
            <input type="file" id="json_file" name="json_file" accept=".json">
        </div>
        <button type="submit" name="submit">Publier le patron</button>
    </form>

    <p class="form-footer"><a href="index.php">← Retour à l'accueil</a></p>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
