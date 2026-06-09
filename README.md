# Pixknit — Plateforme web de patrons pixel

Plateforme web communautaire pour créer, partager et découvrir des patrons pixel destinés au tricot, au crochet et à la broderie. Pixknit fait le pont entre le pixel art et le textile : un patron de tricot n'est qu'une grille de pixels colorés.

**Application desktop associée :** [Pixnit (PyQt6)](https://github.com/Misskine/Pixnit)

---
## Table des matières

1. [Fonctionnalités](#fonctionnalités)
2. [Documentation](#documentation)
3. [Stack technique](#stack-technique)
4. [Installation](#installation)
   - [Prérequis](#prérequis)
   - [Étapes](#étapes)
5. [Structure du projet](#structure-du-projet)
6. [Schéma de la base de données](#schéma-de-la-base-de-données)
7. [Design & charte graphique](#design--charte-graphique)
8. [Sécurité](#sécurité)
9. [Format du fichier patron JSON](#format-du-fichier-patron-json)
10. [Équipe — Mojo-Jojo de fil et de laine](#équipe--mojo-jojo-de-fil-et-de-laine)
11. [Licence](#licence)
12. [Liens utiles](#liens-utiles)

---

## Fonctionnalités

- **Galerie de patrons** — grille style Pinterest avec aperçu canvas
- **Comptes utilisateurs** — inscription, connexion, photo de profil
- **Upload de patrons** — import de fichiers JSON exportés depuis l'app desktop
- **Likes & commentaires** — interaction sociale autour des créations
- **Recherche** — par titre, tag, ou créateur
- **Téléchargements** — export PNG / JSON / PDF de chaque patron
- **Métadonnées** — difficulté (débutant à expert), temps estimé, tags
- **Design responsive** — compatible mobile, tablette, desktop

---

## Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend   | PHP 7.4+ (PDO, sessions) |
| Base de données | MySQL / MariaDB (utf8mb4) |
| Frontend  | HTML5, CSS3 (Grid + Flexbox), Vanilla JS |
| Polices   | Google Fonts (Fraunces + DM Sans) |
| Serveur   | Apache (XAMPP / WAMP / LAMP) |

---

## Installation

### Prérequis

- **XAMPP** (ou équivalent : WAMP, MAMP, LAMP) avec PHP 7.4+ et MySQL
- Un navigateur moderne (Chrome, Firefox, Edge, Safari)

### Étapes

1. **Cloner le dépôt** dans le dossier `htdocs` de XAMPP :
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/Misskine/Pixnit-web.git pixknit
   ```

2. **Démarrer Apache et MySQL** depuis le panneau XAMPP.

3. **Créer la base de données** : ouvrir [phpMyAdmin](http://localhost/phpmyadmin), puis importer le fichier `db.sql` :
   ```sql
   CREATE DATABASE pixknit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   Puis exécuter le contenu de `db.sql`.

4. **Configurer la connexion DB** dans `bd.php` si nécessaire :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'pixknit');
   define('DB_USER', 'root');
   define('DB_PASSWORD', '');
   ```

5. **Vérifier les permissions** du dossier `uploads/` (lecture + écriture).

6. **Accéder au site** : [http://localhost/pixknit](http://localhost/pixknit)

---

## Structure du projet

```
pixknit/
├── assets/              # Images, icônes, logos
├── uploads/             # Fichiers uploadés (avatars, patrons)
├── bd.php               # Connexion PDO à la base
├── db.sql               # Schéma de la base de données
│
├── index.php            # Page d'accueil
├── about.php            # À propos (Mojo-Jojo, mission)
├── app.php              # Présentation de l'application desktop
├── connexion.php        # Page de connexion
├── inscription.php      # Page d'inscription
├── deconnexion.php      # Destruction de session
├── profil.php           # Profil utilisateur + ses patrons
├── upload.php           # Publier un nouveau patron
├── patron.php           # Page détail d'un patron (likes, commentaires)
├── recherche.php        # Recherche et exploration
├── like.php             # Endpoint AJAX pour liker/déliker
├── telecharger.php      # Téléchargement d'un patron
│
├── header.php           # Barre de navigation (incluse partout)
├── footer.php           # Pied de page (inclus partout)
│
├── style.css            # Feuille de style unique
└── README.md
```

---

## Schéma de la base de données

| Table | Description |
|-------|-------------|
| `users` | Comptes utilisateurs (pseudo, email, mot de passe haché, photo de profil) |
| `patrons` | Patrons publiés (titre, description, grille JSON, tags, difficulté, temps) |
| `likes` | Relation N:N entre utilisateurs et patrons |
| `commentaires` | Commentaires sur les patrons |

Toutes les clés étrangères utilisent `ON DELETE CASCADE` pour la cohérence.

---

## Design & charte graphique

- **Tokens CSS** centralisés dans `:root` (couleurs, rayons, ombres)
- **Couleurs principales :**
  - `--lime: #c8f062` — accent vert tilleul
  - `--cream: #f7f4ed` — fond crème
  - `--dark: #1c1c1c` — texte principal
- **Typographie :**
  - `Fraunces` (serif) pour les titres
  - `DM Sans` (sans-serif) pour le corps
- **CSS organisé par sections** : tokens → reset → composants globaux → styles spécifiques à chaque page (en-têtes `/* PAGE : xxx.php */`)

---

## Format du fichier patron JSON

Les patrons doivent être au format suivant (généré par l'app desktop Pixnit) :

```json
{
  "couleurs": [
    ["#ffffff", "#c8f062", "#1c1c1c"],
    ["#c8f062", "#1c1c1c", "#c8f062"],
    ["#1c1c1c", "#c8f062", "#ffffff"]
  ]
}
```

La clé `couleurs` contient un tableau 2D de codes hexadécimaux représentant la grille pixel.

---

## Équipe — Mojo-Jojo de fil et de laine

Société passionnée par les arts textiles, créant des outils numériques modernes pour les loisirs créatifs.

**Mission :** créer des ponts entre le numérique et le textile pour attirer un public de 15 à 35 ans vers le tricot, le crochet et la broderie.

---

## Licence

Open source — gratuit pour usage personnel et éducatif.

---

## Liens utiles

- [Site web — Code source](https://github.com/Misskine/Pixnit-web)
- [Application desktop — Code source](https://github.com/Misskine/Pixnit)
- [Documentation complète sur Notion](https://app.notion.com/p/Documentation-Pixnit-Desktop-Client-lourd-37896ee36acd804b8f5ee060d7ef8466?source=copy_link)
- [Signaler un bug](https://github.com/Misskine/Pixnit-web/issues)
