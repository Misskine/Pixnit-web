<footer>
    <div style="max-width:1200px;margin:0 auto;padding:0 48px;width:100%;">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:40px;padding:56px 0 40px;border-bottom:1px solid rgba(255,255,255,.1);">

            <!-- Logo + tagline -->
            <div style="display:flex;flex-direction:column;gap:10px;">
                <div class="footer-logo">pixknit<span class="footer-logo-dot"></span></div>
                <p class="footer-tagline">Une communauté de créateur·ices<br>pixel — depuis 2026</p>
            </div>

            <!-- Liens -->
            <div style="display:flex;flex-direction:column;gap:6px;">
                <p style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:8px;">Navigation</p>
                <a href="index.php"    class="footer-link">Accueil</a>
                <a href="recherche.php" class="footer-link">Explorer</a>
                <a href="upload.php"   class="footer-link">Partager un patron</a>
                <a href="app.php"      class="footer-link">Application de bureau</a>
                <a href="about.php"    class="footer-link">Notre histoire</a>
            </div>

            <!-- Compte -->
            <div style="display:flex;flex-direction:column;gap:6px;">
                <p style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:8px;">Compte</p>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profil.php?id=<?= $_SESSION['user_id'] ?>" class="footer-link">Mon profil</a>
                    <a href="deconnexion.php" class="footer-link">Se déconnecter</a>
                <?php else: ?>
                    <a href="connexion.php"  class="footer-link">Connexion</a>
                    <a href="inscription.php" class="footer-link">Créer un compte</a>
                <?php endif; ?>
            </div>

        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:20px 0;flex-wrap:wrap;gap:8px;">
            <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.2);">© 2026 pixknit — tous droits réservés</p>
            <p style="font-family:'DM Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.2);">tricot · crochet · pixel art · point de croix</p>
        </div>
    </div>
</footer>
