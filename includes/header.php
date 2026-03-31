<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayari.tn — Premium Smart TV Tunisie</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Ayari_Shop/assets/css/style.css">
</head>

<body>

    <?php
    // On récupère le chemin actuel pour la sidebar active
    $current_page = basename($_SERVER['PHP_SELF']);
    $is_admin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
    ?>

    <?php if (!$is_admin): ?>
        <header class="header">
            <div class="container nav">
                <a href="/Ayari_Shop/index.php" class="logo">AYARI<span>.TN</span></a>

                <nav class="nav-links">
                    <a href="/Ayari_Shop/index.php"
                        class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a>
                    <a href="/Ayari_Shop/products.php"
                        class="nav-link <?php echo ($current_page == 'products.php' || $current_page == 'product-details.php') ? 'active' : ''; ?>">Produits</a>
                    <a href="/Ayari_Shop/login.php" class="nav-link">Admin</a>
                </nav>

                <a href="/Ayari_Shop/cart.php" class="nav-cart">
                    Panier (<?php echo getCartCount(); ?>)
                </a>
            </div>
        </header>
    <?php endif; ?>