# 🛒 Ayari Shop — Plateforme E-Commerce Smart TV

![PHP](https://img.shields.io/badge/PHP-Procédural-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=flat&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-Sémantique-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-Responsive-1572B6?style=flat&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-F7DF1E?style=flat&logo=javascript&logoColor=black)

> Projet de Fin d'Année — Module **Programmation Web 2**
> ISAAS Sfax | 2ème Licence BI | Étudiant : **Bilel Ayari** | Encadrant : **M. Anis Ben Ammar**

---

## 📌 Présentation

**Ayari Shop** est une plateforme e-commerce tunisienne dédiée à la vente de
téléviseurs Smart TV. Développée **from scratch** sans framework, elle simule
fidèlement une vraie enseigne technologique premium sur le marché tunisien.

---

## 🎬 Démonstration

| 🎥 Vidéo démo | 🌐 GitHub Pages |
|---|---|
| [Voir la démo](#) | [Lancer le site](#) |

---

## ✨ Fonctionnalités

### 🛍️ Front-Office (Client)
- 📦 Catalogue dynamique de 20+ Smart TV (cartes interactives)
- 🛒 Panier persistant via `$_SESSION` (ajout, quantité, suppression)
- 💳 Processus de commande complet avec récapitulatif financier
- 📱 Design responsive premium (Flexbox + Grid CSS)

### ⚙️ Back-Office (Admin)
- 🔐 Authentification sécurisée (Bcrypt + sessions PHP)
- 📊 Dashboard KPI temps réel (CA, commandes, top ventes)
- 🖼️ CRUD Produits avec upload d'images sécurisé
- 👥 Gestion des utilisateurs (admin / modérateur)

---

## 🗂️ Structure du Projet

```
ayari-shop/
├── index.php              # Page d'accueil
├── products.php           # Catalogue produits
├── cart.php               # Panier
├── checkout.php           # Validation commande
├── admin/
│   ├── index.php          # Dashboard
│   ├── products.php       # CRUD produits
│   ├── users.php          # Gestion utilisateurs
│   └── login.php          # Authentification
├── includes/
│   ├── db.php             # Connexion MySQL
│   ├── auth.php           # Vérification session
│   ├── header.php         # En-tête partagé
│   └── footer.php         # Pied de page partagé
└── assets/
    ├── css/style.css      # Charte graphique centralisée
    └── images/            # Images uploadées
```

---

## 🗄️ Base de Données

```sql
-- 4 tables principales
CREATE TABLE users       -- Administrateurs (Bcrypt)
CREATE TABLE products    -- Catalogue Smart TV
CREATE TABLE orders      -- Commandes clients
CREATE TABLE order_items -- Détail commandes (One-To-Many)
```

---

## 🚀 Installation Locale

```bash
# 1. Cloner le dépôt
git clone https://github.com/bilel-ayari/ayari-shop.git

# 2. Démarrer XAMPP (Apache + MySQL)
# 3. Copier le dossier dans /htdocs/
# 4. Importer la base de données
#    → phpMyAdmin → Importer → ayari_shop.sql

# 5. Configurer la connexion
# Modifier includes/db.php :
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ayari_shop";

# 6. Accéder au site
http://localhost/ayari-shop/
http://localhost/ayari-shop/admin/  # admin / password
```

---

## 🔒 Sécurité Implémentée

| Menace | Protection |
|---|---|
| Injection SQL | `mysqli_real_escape_string()` |
| Mots de passe | `password_hash()` Bcrypt |
| Upload malveillant | Whitelist extensions + `uniqid()` |
| Accès admin non autorisé | Vérification session via `auth.php` |

---

## 🛠️ Stack Technique

| Couche | Technologie |
|---|---|
| Frontend | HTML5, CSS3, JavaScript (Vanilla) |
| Backend | PHP (Procédural, sans framework) |
| Base de données | MySQL via `mysqli` |
| Environnement | XAMPP / Apache |

---

## 👨‍💻 Auteur

**Bilel Ayari**
2ème Licence Business Intelligence — ISAAS Sfax
Encadrant : M. Anis Ben Ammar

---

*Projet académique — Module Programmation Web 2 — 2024/2025*
