<?php
session_start();
require_once 'bd.php';

$erreur = '';
$email  = '';

if (isset($_POST['submit'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo']  = $user['pseudo'];
            $_SESSION['pp']      = $user['pp'] ?? null;
            header("Location: index.php");
            exit();
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — PixKnit</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div style="display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 68px);">

    <!-- Gauche : formulaire -->
    <div style="display:flex;align-items:center;justify-content:center;padding:64px 48px;background:var(--white);">
        <div style="width:100%;max-width:400px;display:flex;flex-direction:column;gap:22px;">

            <div>
                <a href="index.php" style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.04em;">← Retour</a>
                <h1 style="font-family:'Fraunces',serif;font-size:42px;font-weight:900;letter-spacing:-0.02em;margin-top:20px;">Connexion</h1>
                <p style="font-size:15px;font-weight:300;color:var(--mid);margin-top:6px;">Content·e de te revoir !</p>
            </div>

            <?php if ($erreur): ?>
                <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>

            <form method="POST" action="connexion.php" style="display:flex;flex-direction:column;gap:16px;">
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
                <button type="submit" name="submit" style="width:100%;padding:15px;font-size:14px;margin-top:4px;">Se connecter →</button>
            </form>

            <p style="font-family:'DM Sans',sans-serif;font-size:14px;color:var(--muted);text-align:center;">
                Pas encore de compte ?
                <a href="inscription.php" style="color:var(--dark);font-weight:700;text-decoration:underline;text-underline-offset:3px;">S'inscrire gratuitement</a>
            </p>

        </div>
    </div>

    <!-- Droite : image habillée -->
    <div style="position:relative;overflow:hidden;background:var(--dark);">
        <img src="assets/you1.jpg" alt="Communauté pixknit" loading="eager" decoding="async"
             style="width:100%;height:100%;object-fit:cover;display:block;opacity:.7;">
        <!-- Overlay gradient -->
        <div style="position:absolute;inset:0;background:linear-gradient(135deg, rgba(200,240,98,.35) 0%, rgba(28,28,28,.6) 100%);"></div>
        <!-- Contenu flottant -->
        <div style="position:absolute;bottom:48px;left:48px;right:48px;">
            <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.2);border-radius:20px;padding:28px 32px;">
                <div style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--lime);margin-bottom:10px;">communauté</div>
                <p style="font-family:'Fraunces',serif;font-size:24px;font-weight:700;font-style:italic;color:#fff;line-height:1.3;margin-bottom:16px;">
                    « Des centaines de créateur·ices partagent leurs patrons chaque semaine. »
                </p>
                <div style="display:flex;gap:8px;">
                    <span style="background:var(--lime);color:var(--dark);font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;padding:4px 12px;border-radius:999px;">🧶 tricot</span>
                    <span style="background:rgba(255,255,255,.15);color:#fff;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;padding:4px 12px;border-radius:999px;">pixel art</span>
                    <span style="background:rgba(255,255,255,.15);color:#fff;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;padding:4px 12px;border-radius:999px;">gratuit</span>
                </div>
            </div>
        </div>
        <!-- Logo watermark -->
        <div style="position:absolute;top:40px;left:48px;font-family:'Fraunces',serif;font-size:22px;font-weight:900;font-style:italic;color:#fff;letter-spacing:-0.02em;opacity:.8;">
            pixknit<span style="display:inline-block;width:7px;height:7px;background:var(--lime);border-radius:50%;margin-left:2px;vertical-align:middle;position:relative;top:-2px;"></span>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
