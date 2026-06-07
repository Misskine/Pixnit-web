<nav class="nav">

    <!-- Gauche : recherche -->
    <div class="nav-search">
        <form method="GET" action="recherche.php" class="nav-search-form">
            <svg class="nav-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" name="q" placeholder="Patron, tag, créateur…"
                   value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        </form>
    </div>

    <!-- Centre : logo + nom -->
    <a href="index.php" class="nav-logo">
        <img src="assets/logo.svg" alt="Logo Pixnit" width="28" height="28" style="image-rendering:pixelated;">
        pixknit
    </a>

    <!-- Droite : liens + compte -->
    <div class="nav-right">
        <a href="recherche.php" class="nav-link <?= basename($_SERVER['PHP_SELF'])==='recherche.php'?'active':'' ?>">Explorer</a>
        <a href="upload.php"    class="nav-link <?= basename($_SERVER['PHP_SELF'])==='upload.php'   ?'active':'' ?>">Partager</a>
        <a href="app.php"       class="nav-link <?= basename($_SERVER['PHP_SELF'])==='app.php'      ?'active':'' ?>">Application</a>
        <a href="about.php"     class="nav-link <?= basename($_SERVER['PHP_SELF'])==='about.php'    ?'active':'' ?>">À propos</a>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profil.php?id=<?= $_SESSION['user_id'] ?>" class="nav-avatar-link" title="Mon profil">
                <?php if (!empty($_SESSION['pp'])): ?>
                    <img src="<?= htmlspecialchars($_SESSION['pp']) ?>" alt="Photo de profil de <?= htmlspecialchars($_SESSION['pseudo']) ?>" class="nav-avatar-img">
                <?php else: ?>
                    <span class="nav-avatar-initiale"><?= strtoupper(mb_substr($_SESSION['pseudo'],0,1)) ?></span>
                <?php endif; ?>
            </a>
            <a href="deconnexion.php" class="nav-link" title="Se déconnecter" style="padding:8px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </a>
        <?php else: ?>
            <a href="connexion.php"  class="nav-link">Connexion</a>
            <a href="inscription.php" class="btn-primary">S'inscrire</a>
        <?php endif; ?>
    </div>

</nav>
