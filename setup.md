# 🛠️ Guide d'Installation et de Configuration — Ayari Shop

Ce guide détaille les étapes nécessaires pour déployer et configurer le projet **Ayari Shop** sur un environnement de développement local (XAMPP/WAMP).

---

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine (idéalement sous Windows, macOS ou Linux) :
- Serveur local comme **XAMPP** (recommandé), incluant **Apache** et **MySQL / MariaDB**.
- **Git** (optionnel, uniquement si vous clonez le dépôt).
- Un éditeur de code de votre choix (ex: **VS Code**, **Sublime Text**).

---

## 🚀 Étape 1 : Préparation des fichiers

1. **Démarrer le serveur local :**
   - Lancez le panneau de contrôle XAMPP.
   - Cliquez sur "Start" pour **Apache** et **MySQL**.

2. **Déplacer le projet dans le répertoire Web :**
   - Si vous utilisez Git, clonez le dépôt directement dans le dossier principal de votre serveur web local (pour XAMPP, c'est le répertoire `htdocs`, souvent situé dans `C:\xampp\htdocs\`) :
     ```bash
     cd C:\xampp\htdocs\
     git clone https://github.com/bilel-ayari/ayari-shop.git Ayari_Shop
     ```
   - *Alternative :* Si vous possédez le projet sous forme d'archive ZIP, extrayez simplement son contenu et renommez le dossier extrait en `Ayari_Shop`. Placez ce dossier dans `C:\xampp\htdocs\`.

---

## 🗄️ Étape 2 : Configuration de la Base de Données

1. **Accéder à l'interface de gestion MySQL (phpMyAdmin) :**
   - Ouvrez votre navigateur web et rendez-vous sur : [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

2. **Créer une nouvelle base de données :**
   - Cliquez sur l'onglet **Base de données** (en haut de l'interface).
   - Dans le champ "Nom de base de données", saisissez : `ayari_shop`
   - Sélectionnez l'interclassement `utf8mb4_unicode_ci` (recommandé pour la prise en charge correcte des caractères spéciaux et des emojis) et cliquez sur **Créer**.

3. **Importer la structure et les données (Les tables) :**
   - Dans la colonne de gauche, cliquez sur la base de données `ayari_shop` que vous venez de créer.
   - Cliquez sur l'onglet **Importer** (dans le menu principal en haut).
   - Dans la section "Fichier à importer", cliquez sur **Choisir un fichier**.
   - Naviguez dans les dossiers du projet et sélectionnez le fichier SQL (ex: `ayari_shop.sql` ou `database.sql` qui contient les 4 tables principales `users`, `products`, `orders`, `order_items`).
   - Allez tout en bas de la page et cliquez sur le bouton **Exécuter** (ou Importer).

---

## ⚙️ Étape 3 : Configuration de la Connexion PHP

L'application web doit pouvoir dialoguer avec la base de données. Il faut paramétrer les identifiants de connexion.

1. **Ouvrir le fichier de connexion :**
   - Allez dans le répertoire du projet `Ayari_Shop/includes/` et ouvrez le fichier `db.php` avec votre éditeur de code.

2. **Vérifier les identifiants de connexion MySQL :**
   - Vérifiez que les informations correspondent à la configuration par défaut de votre serveur XAMPP :

```php
<?php
// Configuration par défaut pour XAMPP en local
$host = "localhost";
$user = "root";       // Utilisateur MySQL par défaut
$pass = "";           // Le mot de passe est généralement vide sous Windows/XAMPP
$db   = "ayari_shop"; // Nom de la base défini à l'Étape 2

// Le code de connexion mysqli() se trouve en dessous de ces variables
?>
```
*(Si vous avez défini un mot de passe pour l'utilisateur root dans XAMPP, pensez à le spécifier dans la variable `$pass`)*.

---

## 🌐 Étape 4 : Lancement et Vérification

Le projet est configuré et prêt à être testé !

1. **Espace Client (Front-Office) :**
   - Ouvrez votre navigateur et entrez l'adresse : [http://localhost/Ayari_Shop/](http://localhost/Ayari_Shop/)
   - Vous devez voir apparaître la page d'accueil avec le catalogue interactif des Smart TVs.

2. **Espace Administration (Back-Office) :**
   - Pour accéder au tableau de bord (Dashboard), allez sur : [http://localhost/Ayari_Shop/admin/](http://localhost/Ayari_Shop/admin/)
   - Utilisez les identifiants par défaut fournis par la base de données importée.
     - *Exemple de compte par défaut (si présent dans le projet) :*
       - **Login / Email :** `admin` ou l'adresse email configurée
       - **Mot de passe :** `password` ou le mot de passe fourni

---

## 🚨 Dépannage Courant

- **Erreur "Access Denied" ou "Connection Failed" :**
  Vérifiez que MySQL est bien démarré dans XAMPP. Vérifiez également les informations du fichier `includes/db.php` (surtout le mot de passe, qui doit être vide sous XAMPP par défaut).
- **Problème d'affichage d'images (Back-office) :**
  Les images des produits téléversées via le back-office sont stockées dans le dossier `assets/images/`. Veillez à ce que ce dossier ne soit pas en "Lecture seule".
- **Erreur "Uncaught Error: Call to undefined function mysqli_connect()" :**
  L'extension `mysqli` n'est pas activée dans votre fichier `php.ini`. (Elle est activée par défaut sous XAMPP).

---
*Projet développé dans le cadre du module Programmation Web 2 — ISAAS Sfax.*
