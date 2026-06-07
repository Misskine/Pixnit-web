<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notre histoire — Pixnit · Mojo-Jojo de fil et de laine</title>
    <link rel="icon" type="image/svg+xml" href="assets/logo.svg">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- ══ HERO ══════════════════════════════════════════ -->
<div class="about-hero">

    <!-- Gauche : grand titre sombre -->
    <div class="about-hero-left">
        <span style="display:inline-block;background:rgba(200,240,98,.15);border:1px solid rgba(200,240,98,.25);border-radius:999px;padding:6px 16px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--lime);margin-bottom:24px;">Notre histoire</span>

        <h1 style="font-family:'Fraunces',serif;font-size:62px;font-weight:900;letter-spacing:-0.03em;line-height:1;color:var(--white);margin-bottom:24px;">
            Le tricot a<br>
            <em style="font-style:italic;color:var(--lime);">toujours été</em><br>
            du code.
        </h1>

        <p style="font-family:'DM Sans',sans-serif;font-size:17px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.7;max-width:440px;">
            Des tisseuses aux programmatrices, les femmes ont toujours utilisé des systèmes logiques complexes bien avant que l'informatique ait un nom.
        </p>

        <div style="margin-top:36px;display:flex;gap:16px;align-items:center;">
            <a href="#histoire" style="background:var(--lime);color:var(--dark);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;padding:13px 28px;border-radius:999px;text-decoration:none;">
                Lire l'histoire ↓
            </a>
            <a href="#mojo" style="font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;color:rgba(255,255,255,.45);text-decoration:underline;text-underline-offset:3px;">
                À propos de Mojo-Jojo
            </a>
        </div>
    </div>

    <!-- Droite : fond lime + chiffres clés -->
    <div class="about-hero-right">
        <div>
            <p style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(0,0,0,.4);margin-bottom:8px;">Le projet pixnit</p>
            <p class="big-quote" style="color:var(--dark);">
                "Rendre les arts textiles désirables, accessibles et numériques pour la génération d'aujourd'hui."
            </p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:8px;">
            <div style="background:var(--white);border-radius:16px;padding:20px 22px;">
                <span style="font-family:'Fraunces',serif;font-size:40px;font-weight:900;color:var(--dark);display:block;line-height:1;">15–35</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(0,0,0,.4);">ans, notre cible</span>
            </div>
            <div style="background:var(--dark);border-radius:16px;padding:20px 22px;">
                <span style="font-family:'Fraunces',serif;font-size:40px;font-weight:900;color:var(--lime);display:block;line-height:1;">100%</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.35);">gratuit & open</span>
            </div>
            <div style="background:var(--dark);border-radius:16px;padding:20px 22px;">
                <span style="font-family:'Fraunces',serif;font-size:40px;font-weight:900;color:var(--lime);display:block;line-height:1;">∞</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.35);">créativité possible</span>
            </div>
            <div style="background:var(--white);border-radius:16px;padding:20px 22px;">
                <span style="font-family:'Fraunces',serif;font-size:40px;font-weight:900;color:var(--dark);display:block;line-height:1;">2026</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(0,0,0,.4);">lancement</span>
            </div>
        </div>
    </div>

</div>


<!-- ══ HISTOIRE : FEMMES & INFORMATIQUE ══════════════ -->
<div class="about-section" style="background:var(--dark);" id="histoire">
<div class="about-section-inner">

    <div style="text-align:center;margin-bottom:72px;">
        <span style="display:inline-block;background:rgba(200,240,98,.15);border:1px solid rgba(200,240,98,.25);border-radius:999px;padding:6px 16px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--lime);margin-bottom:18px;">Elles ont tout inventé</span>
        <h2 style="font-family:'Fraunces',serif;font-size:48px;font-weight:900;letter-spacing:-0.02em;color:var(--white);line-height:1.0;max-width:700px;margin:0 auto;">
            Les femmes à l'origine de <em style="font-style:italic;background:var(--lime);color:var(--dark);padding:0 8px;border-radius:8px;">l'informatique moderne</em>
        </h2>
        <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.4);margin-top:16px;max-width:580px;margin-left:auto;margin-right:auto;line-height:1.7;">
            Bien avant les ordinateurs, les tisseuses utilisaient des systèmes binaires complexes. Voici leur histoire.
        </p>
    </div>

    <div class="timeline">

        <div class="timeline-item">
            <div class="timeline-year">XIXᵉ s.</div>
            <div class="timeline-dot-col"><div class="timeline-dot"></div><div class="timeline-line"></div></div>
            <div class="timeline-content">
                <div class="person-chip">Les tisseuses Jacquard</div>
                <h3>Les premières programmatrices sans le savoir</h3>
                <p>Les ouvrières qui opéraient les métiers Jacquard en France maîtrisaient un système de cartes perforées pour créer des motifs complexes. Chaque carte était un « programme » — une séquence d'instructions binaires (trou/pas trou) pour lever ou baisser les fils. Elles programmiaient des motifs que les ordinateurs ne pourraient reproduire qu'un siècle plus tard.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-year">1843</div>
            <div class="timeline-dot-col"><div class="timeline-dot"></div><div class="timeline-line"></div></div>
            <div class="timeline-content">
                <div class="person-chip">Ada Lovelace</div>
                <h3>La première programmatrice de l'histoire</h3>
                <p>Ada Lovelace traduit et annote les travaux de Charles Babbage sur sa machine analytique — et rédige ce qui est considéré comme le premier algorithme informatique. Elle s'inspire explicitement du métier Jacquard pour conceptualiser la machine : « Elle tisse des formules algébriques comme le métier Jacquard tisse des fleurs et des feuilles. » Fille du poète Lord Byron, brillante mathématicienne, elle voit en la machine un potentiel bien au-delà du calcul.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-year">1940s</div>
            <div class="timeline-dot-col"><div class="timeline-dot"></div><div class="timeline-line"></div></div>
            <div class="timeline-content">
                <div class="person-chip">Les programmatrices ENIAC</div>
                <h3>Six femmes programmaient le premier ordinateur</h3>
                <p>ENIAC, le premier ordinateur électronique général, était programmé par six femmes : Jean Jennings, Frances Bilas, Betty Holberton, Marlyn Wescoff, Frances Spence et Ruth Lichterman. Recrutées comme « calculatrices humaines » pendant la Seconde Guerre mondiale, elles ont développé des techniques de programmation fondamentales encore utilisées aujourd'hui — sans manuel, sans précédent.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-year">1952</div>
            <div class="timeline-dot-col"><div class="timeline-dot"></div><div class="timeline-line"></div></div>
            <div class="timeline-content">
                <div class="person-chip">Grace Hopper</div>
                <h3>Elle a inventé le premier compilateur</h3>
                <p>Amiral de la marine américaine et informaticienne hors pair, Grace Hopper développe le premier compilateur — un programme qui traduit le langage humain en code machine. Elle popularise l'idée que la programmation ne devrait pas être réservée aux mathématiciens. On lui doit aussi le terme « debugging » après avoir trouvé un vrai insecte bloqué dans un relais de son ordinateur.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-year">1969</div>
            <div class="timeline-dot-col"><div class="timeline-dot"></div><div class="timeline-line"></div></div>
            <div class="timeline-content">
                <div class="person-chip">Margaret Hamilton</div>
                <h3>Le code qui a envoyé l'Homme sur la Lune</h3>
                <p>Directrice du département logiciel au MIT pour la NASA, Margaret Hamilton dirige l'équipe qui écrit le logiciel embarqué d'Apollo 11. Son code — imprimé sur des milliers de pages — a permis à Neil Armstrong et Buzz Aldrin de marcher sur la Lune. Elle invente le terme « software engineering » pour légitimer son travail face aux ingénieurs hardware sceptiques.</p>
            </div>
        </div>

        <div class="timeline-item">
            <div class="timeline-year">Auj.</div>
            <div class="timeline-dot-col"><div class="timeline-dot" style="background:var(--white);"></div></div>
            <div class="timeline-content">
                <div class="person-chip" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:var(--white);">Toi</div>
                <h3 style="color:var(--white);">La boucle est bouclée</h3>
                <p>Du métier à tisser à l'algorithme, du fil au pixel — pixnit réunit ces deux histoires. Créer un patron de tricot, c'est programmer. Partager ses mailles, c'est open source. Rejoins une tradition vieille de plusieurs siècles, réinventée pour aujourd'hui.</p>
            </div>
        </div>

    </div>

</div>
</div>


<!-- ══ POURQUOI LE TRICOT POUR LES JEUNES ════════════ -->
<div class="about-section" style="background:var(--white);">
<div class="about-section-inner">

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;margin-bottom:64px;">
        <div>
            <span style="display:inline-block;background:var(--lime);border-radius:999px;padding:6px 16px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--dark);margin-bottom:18px;">15 – 35 ans</span>
            <h2 style="font-family:'Fraunces',serif;font-size:48px;font-weight:900;letter-spacing:-0.02em;line-height:1.05;">
                Pourquoi le tricot<br>est le hobby<br><em style="font-style:italic;">de notre génération</em>
            </h2>
        </div>
        <div>
            <p style="font-size:17px;font-weight:300;color:var(--mid);line-height:1.8;">
                Dans un monde saturé d'écrans et de contenus instantanés, les arts textiles offrent quelque chose de rare : <strong style="color:var(--dark);font-weight:600;">le plaisir de créer quelque chose de réel, avec ses mains, qui dure.</strong>
            </p>
            <p style="font-size:17px;font-weight:300;color:var(--mid);line-height:1.8;margin-top:16px;">
                De plus en plus de 15–35 ans redécouvrent le tricot, le crochet et la broderie — non pas par nostalgie, mais parce que ces pratiques répondent à des besoins profonds que les applications ne comblent pas.
            </p>
        </div>
    </div>

    <!-- Bento santé -->
    <div class="health-bento">

        <div class="health-card dark big">
            <img src="assets/iconyarn.jpg" alt="Icône pelote de laine" style="width:56px;height:56px;object-fit:cover;border-radius:12px;margin-bottom:14px;display:block;">
            <h3>Le meilleur antistress prouvé</h3>
            <p>Des études en neurosciences montrent que le tricot active les mêmes zones cérébrales que la méditation. Le mouvement répétitif des mains libère de la sérotonine et réduit le cortisol — l'hormone du stress. Plusieurs thérapeutes prescrivent désormais le crochet comme outil de gestion de l'anxiété et de la dépression légère. Un podcast, une série, une heure de tricot = reset mental complet.</p>
            <div style="display:flex;gap:16px;margin-top:20px;flex-wrap:wrap;">
                <div style="background:rgba(200,240,98,.1);border:1px solid rgba(200,240,98,.2);border-radius:12px;padding:12px 18px;">
                    <span style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;color:var(--lime);display:block;">−34%</span>
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(255,255,255,.4);">de cortisol mesuré</span>
                </div>
                <div style="background:rgba(200,240,98,.1);border:1px solid rgba(200,240,98,.2);border-radius:12px;padding:12px 18px;">
                    <span style="font-family:'Fraunces',serif;font-size:28px;font-weight:900;color:var(--lime);display:block;">89%</span>
                    <span style="font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(255,255,255,.4);">se sentent + calmes</span>
                </div>
            </div>
        </div>

        <div class="health-card lime">
            <h3>Bon pour la planète</h3>
            <p>Tricoter ses propres vêtements, c'est dire non à la fast fashion. Réparer plutôt que jeter. Choisir des laines locales et naturelles. L'industrie textile est la 2ᵉ plus polluante au monde — chaque maille tricotée à la main est un acte de résistance douce.</p>
        </div>

        <div class="health-card cream">
            <img src="assets/heartkniticon.png" alt="Icône cœur tricoté" style="width:48px;height:48px;object-fit:cover;border-radius:10px;margin-bottom:14px;display:block;">
            <h3>Une vraie communauté</h3>
            <p>Les cercles de tricot (knitting circles), les Yarn Bombs, les communautés en ligne comme Ravelry ou pixnit créent des liens réels entre personnes de tous horizons. Le tricot transcende les générations — une compétence transmise de grand-mère en petite-fille, maintenant de TikToker en abonnée.</p>
        </div>

        <div class="health-card cream">
            <h3>Fine motricité & cerveau</h3>
            <p>Le tricot développe la coordination bimanuelle, la concentration, et stimule les connexions neuronales. Des études montrent qu'il peut ralentir le déclin cognitif et améliorer la mémoire à long terme.</p>
        </div>

        <div class="health-card dark">
            <span class="health-stat" style="color:var(--lime);">+40%</span>
            <p style="color:rgba(255,255,255,.5);font-size:13px;">de jeunes adultes ont adopté le tricot ou le crochet depuis 2020 — en France, en Europe, au Canada.</p>
        </div>

        <div class="health-card" style="background:var(--dark);border:none;display:flex;align-items:center;justify-content:center;">
            <img src="assets/you1.jpg" alt="Communauté tricot" style="width:100%;height:100%;object-fit:cover;border-radius:18px;opacity:.7;">
        </div>

    </div>

</div>
</div>


<!-- ══ MOJO-JOJO ══════════════════════════════════════ -->
<div class="mojo-section" id="mojo">
<div class="mojo-grid">

    <div>
        <span style="display:inline-block;background:rgba(200,240,98,.15);border:1px solid rgba(200,240,98,.25);border-radius:999px;padding:6px 16px;font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--lime);margin-bottom:24px;">Qui sommes-nous</span>
        <h2 style="font-family:'Fraunces',serif;font-size:48px;font-weight:900;letter-spacing:-0.02em;color:var(--white);line-height:1.05;margin-bottom:24px;">
            Mojo-Jojo<br>
            <em style="font-style:italic;color:var(--lime);">de fil et de laine</em>
        </h2>
        <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.55);line-height:1.8;margin-bottom:20px;">
            Nous sommes une société passionnée par les arts textiles et convaincue que le tricot, le crochet et la broderie méritent une place dans la vie des jeunes d'aujourd'hui.
        </p>
        <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.55);line-height:1.8;margin-bottom:20px;">
            Notre mission : <strong style="color:var(--white);font-weight:600;">créer des ponts entre le numérique et le textile</strong> pour attirer un public de 15 à 35 ans vers des loisirs créatifs qui font du bien — au corps, à l'esprit et à la planète.
        </p>
        <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.55);line-height:1.8;">
            Pixnit est notre premier outil numérique : une plateforme gratuite et open source pour créer, partager et découvrir des patrons pixel adaptés au tricot et au crochet. Simple à utiliser, conçu pour les débutant·es comme pour les expert·es.
        </p>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">

        <div style="background:var(--lime);border-radius:20px;padding:32px;">
            <img src="assets/laptopicon.jpg" alt="Icône ordinateur" style="width:52px;height:52px;object-fit:cover;border-radius:10px;margin-bottom:14px;display:block;">
            <h3 style="font-family:'Fraunces',serif;font-size:24px;font-weight:700;color:var(--dark);margin-bottom:10px;">Notre mission</h3>
            <p style="font-family:'DM Sans',sans-serif;font-size:14px;font-weight:300;color:rgba(0,0,0,.6);line-height:1.7;">Proposer des outils numériques modernes et accessibles pour moderniser les loisirs créatifs textiles et les rendre attractifs pour les nouvelles générations.</p>
        </div>

        <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);border-radius:20px;padding:28px;display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <span style="font-family:'Fraunces',serif;font-size:32px;font-weight:900;color:var(--lime);display:block;line-height:1;">Open</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.3);">source & gratuit</span>
            </div>
            <div>
                <span style="font-family:'Fraunces',serif;font-size:32px;font-weight:900;color:var(--lime);display:block;line-height:1;">FR</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.3);">Made in France</span>
            </div>
            <div>
                <span style="font-family:'Fraunces',serif;font-size:32px;font-weight:900;color:var(--lime);display:block;line-height:1;">Eco</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.3);">Éco-responsable</span>
            </div>
            <div>
                <span style="font-family:'Fraunces',serif;font-size:32px;font-weight:900;color:var(--lime);display:block;line-height:1;">Crea</span>
                <span style="font-family:'DM Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.3);">Communautaire</span>
            </div>
        </div>

    </div>

</div>
</div>


<!-- ══ POURQUOI PIXNIT ════════════════════════════════ -->
<div class="about-section" style="background:var(--cream);">
<div class="about-section-inner">

    <div style="text-align:center;margin-bottom:56px;">
        <h2 style="font-family:'Fraunces',serif;font-size:48px;font-weight:900;letter-spacing:-0.02em;line-height:1.05;">
            Pourquoi <em style="font-style:italic;background:var(--lime);padding:0 8px;border-radius:8px;">pixnit</em> ?
        </h2>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;">

        <div style="background:var(--white);border-radius:20px;border:1.5px solid var(--border-col);padding:32px;">
            <img src="assets/iconyarn.jpg" alt="Icône pelote de laine" style="width:48px;height:48px;object-fit:cover;border-radius:10px;margin-bottom:14px;display:block;">
            <h3 style="font-family:'Fraunces',serif;font-size:22px;font-weight:700;margin-bottom:10px;">Le constat</h3>
            <p style="font-size:14px;font-weight:300;color:var(--mid);line-height:1.7;">Il existait des logiciels de création de patrons, mais aucun ne s'adressait aux jeunes avec un design moderne, une interface intuitive et une dimension communautaire forte.</p>
        </div>

        <div style="background:var(--dark);border-radius:20px;padding:32px;">
            <img src="assets/logo.svg" alt="Logo Pixnit" width="48" height="48" style="image-rendering:pixelated;margin-bottom:14px;display:block;">
            <h3 style="font-family:'Fraunces',serif;font-size:22px;font-weight:700;margin-bottom:10px;color:var(--white);">Le lien pixel–maille</h3>
            <p style="font-size:14px;font-weight:300;color:rgba(255,255,255,.5);line-height:1.7;">Un patron de tricot n'est qu'une grille de pixels colorés. Un pixel art n'est qu'un motif textile en attente d'être tricoté. Pixnit exploite cette équivalence fascinante.</p>
        </div>

        <div style="background:var(--lime);border-radius:20px;padding:32px;">
            <img src="assets/laptopicon.jpg" alt="Icône ordinateur" style="width:48px;height:48px;object-fit:cover;border-radius:10px;margin-bottom:14px;display:block;">
            <h3 style="font-family:'Fraunces',serif;font-size:22px;font-weight:700;margin-bottom:10px;color:var(--dark);">La solution</h3>
            <p style="font-size:14px;font-weight:300;color:rgba(0,0,0,.6);line-height:1.7;">Une plateforme web + application desktop, gratuite, open source, avec un design branché qui parle aux 15–35 ans — et une communauté pour partager ses créations.</p>
        </div>

    </div>

</div>
</div>


<!-- ══ CTA FINAL ══════════════════════════════════════ -->
<div style="background:var(--dark);padding:96px 48px;text-align:center;">
    <img src="assets/logo.svg" width="52" height="52" style="image-rendering:pixelated;display:block;margin:0 auto 20px;" alt="Pixnit">
    <h2 style="font-family:'Fraunces',serif;font-size:52px;font-weight:900;letter-spacing:-0.02em;color:var(--white);margin-bottom:16px;">
        Rejoins le mouvement.
    </h2>
    <p style="font-family:'DM Sans',sans-serif;font-size:16px;font-weight:300;color:rgba(255,255,255,.45);margin-bottom:40px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;">
        Crée tes patrons, partage tes mailles, inspire la communauté. Le tricot n'a jamais été aussi cool.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a href="inscription.php" style="background:var(--lime);color:var(--dark);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;padding:15px 36px;border-radius:999px;text-decoration:none;">
            Créer mon compte gratuit
        </a>
        <a href="app.php" style="background:rgba(255,255,255,.07);border:1.5px solid rgba(255,255,255,.15);color:rgba(255,255,255,.7);font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;padding:13px 28px;border-radius:999px;text-decoration:none;">
            Télécharger l'application
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
