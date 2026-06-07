<?php
session_start();
require_once 'bd.php';

$erreur = '';
$pseudo = '';
$email  = '';

if (isset($_POST['submit'])) {
    $pseudo   = trim($_POST['pseudo']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($pseudo) || empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse e-mail invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR pseudo = ?");
        $stmt->execute([$email, $pseudo]);
        if ($stmt->fetch()) {
            $erreur = "Ce mail ou ce pseudo est déjà utilisé.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$pseudo, $email, $hash]);
            header("Location: connexion.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 68px);">

    <!-- Gauche : image habillée -->
    <div style="position:relative;overflow:hidden;background:var(--dark);">
        <img src="assets/bg-knit.jpg" alt="Texture tricot"
             style="width:100%;height:100%;object-fit:cover;display:block;opacity:.5;">
        <div style="position:absolute;inset:0;background:linear-gradient(160deg, rgba(28,28,28,.3) 0%, rgba(28,46,26,.8) 100%);"></div>
        <!-- Logo watermark -->
        <div style="position:absolute;top:40px;left:48px;font-family:'Fraunces',serif;font-size:22px;font-weight:900;font-style:italic;color:#fff;letter-spacing:-0.02em;opacity:.8;">
            pixknit<span style="display:inline-block;width:7px;height:7px;background:var(--lime);border-radius:50%;margin-left:2px;vertical-align:middle;position:relative;top:-2px;"></span>
        </div>
        <!-- Contenu central -->
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;text-align:center;">
            <div style="background:var(--lime);border-radius:999px;padding:8px 20px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--dark);margin-bottom:20px;">gratuit &amp; ouvert à tous</div>
            <h2 style="font-family:'Fraunces',serif;font-size:44px;font-weight:900;color:#fff;letter-spacing:-0.02em;line-height:1.05;margin-bottom:16px;">
                Rejoins la<br><em style="font-style:italic;">communauté</em>
            </h2>
            <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.65);line-height:1.7;max-width:320px;">
                Partage tes patrons pixel, découvre les créations de la communauté et échange avec des passionné·es.
            </p>
        </div>
        <!-- Cards flottantes décoratives -->
        <div style="position:absolute;bottom:48px;left:32px;background:rgba(255,255,255,.1);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;">
            <div style="width:40px;height:40px;border-radius:8px;overflow:hidden;flex-shrink:0;">
                <img src="assets/videoframe_4131.png" alt="" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div>
                <div style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--lime);">exemple</div>
                <div style="font-family:'Fraunces',serif;font-size:13px;font-weight:700;color:#fff;">Motif pixel art</div>
            </div>
        </div>
        <div style="position:absolute;bottom:48px;right:32px;background:var(--lime);border-radius:14px;padding:14px 20px;">
            <div style="font-family:'Fraunces',serif;font-size:22px;font-weight:900;color:var(--dark);line-height:1;">100%</div>
            <div style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(0,0,0,.5);margin-top:2px;">gratuit</div>
        </div>
    </div>

    <!-- Droite : formulaire -->
    <div style="display:flex;align-items:center;justify-content:center;padding:64px 48px;background:var(--white);">
        <div style="width:100%;max-width:400px;display:flex;flex-direction:column;gap:22px;">

            <div>
                <a href="index.php" style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.04em;">← Retour</a>
                <h1 style="font-family:'Fraunces',serif;font-size:42px;font-weight:900;letter-spacing:-0.02em;margin-top:20px;">Créer un compte</h1>
                <p style="font-size:15px;font-weight:300;color:var(--mid);margin-top:6px;">C'est gratuit et ça prend 30 secondes.</p>
            </div>

            <?php if ($erreur): ?>
                <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>

            <form method="POST" action="inscription.php" style="display:flex;flex-direction:column;gap:16px;">
                <div>
                    <label style="display:block;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--mid);margin-bottom:8px;">Pseudo</label>
                    <input type="text" name="pseudo" value="<?= htmlspecialchars($pseudo) ?>" placeholder="ton_pseudo"
                           style="width:100%;padding:13px 20px;border:1.5px solid rgba(0,0,0,.12);border-radius:999px;font-family:'DM Sans',sans-serif;font-size:15px;background:var(--cream);color:var(--dark);outline:none;">
                </div>
                <div>
                    <label style="display:block;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--mid);margin-bottom:8px;">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="ton@email.com"
                           style="width:100%;padding:13px 20px;border:1.5px solid rgba(0,0,0,.12);border-radius:999px;font-family:'DM Sans',sans-serif;font-size:15px;background:var(--cream);color:var(--dark);outline:none;">
                </div>
                <div>
                    <label style="display:block;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--mid);margin-bottom:8px;">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••"
                           style="width:100%;padding:13px 20px;border:1.5px solid rgba(0,0,0,.12);border-radius:999px;font-family:'DM Sans',sans-serif;font-size:15px;background:var(--cream);color:var(--dark);outline:none;">
                </div>
                <button type="submit" name="submit" style="width:100%;padding:15px;font-size:14px;margin-top:4px;">Créer mon compte →</button>
            </form>

            <p style="font-family:'DM Sans',sans-serif;font-size:14px;color:var(--muted);text-align:center;">
                Déjà un compte ?
                <a href="connexion.php" style="color:var(--dark);font-weight:700;text-decoration:underline;text-underline-offset:3px;">Se connecter</a>
            </p>

        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
