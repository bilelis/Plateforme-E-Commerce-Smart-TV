<?php
include 'includes/db.php';

// Gestion de l'ajout au panier
if (isset($_GET['add_to_cart'])) {
    $id = intval($_GET['add_to_cart']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $item = mysqli_fetch_assoc($res);

    if ($item) {
        $found = false;
        foreach ($_SESSION['cart'] as &$c) {
            if ($c['id'] == $id) {
                $c['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image'],
                'quantity' => 1
            ];
        }
    }
    header("Location: cart.php");
    exit();
}

include 'includes/header.php';
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div style="padding: 60px 0;">
    <div class="container">
        <div class="section-head">
            <h1>Notre <span>Catalogue</span></h1>
            <p><?php echo mysqli_num_rows($result); ?> téléviseurs disponibles actuellement</p>
        </div>

        <div class="grid">
            <?php while ($product = mysqli_fetch_assoc($result)):
                $isPromo = ($product['id'] % 3 == 0);
                ?>
                <div class="pcard">
                    <div class="install-badge">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" />
                        </svg>
                        <span>Gratuit</span>
                    </div>
                    <div class="pcard-heart"><svg viewBox="0 0 24 24">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                        </svg></div>

                    <?php if ($isPromo): ?>
                        <div class="pcard-badge badge-promo">Promo</div>
                    <?php else: ?>
                        <div class="pcard-badge badge-new">Nouveau</div><?php endif; ?>

                    <a href="product-details.php?id=<?php echo $product['id']; ?>" class="pcard-img-wrap">
                        <img src="assets/images/<?php echo $product['image']; ?>"
                            onerror="this.src='https://placehold.co/400x300/f4f6fb/999?text=Smart+TV'">
                    </a>

                    <div class="pcard-body">
                        <p class="pcard-ref">Réf : <span>REF-<?php echo $product['id']; ?></span></p>
                        <h3 class="pcard-name"><?php echo htmlspecialchars($product['name']); ?></h3>

                        <div class="pcard-price-row">
                            <span class="pcard-price"><?php echo number_format($product['price'], 3, '.', ' '); ?>
                                <small>DT</small></span>
                            <?php if ($isPromo): ?><span
                                    class="pcard-old-price"><?php echo number_format($product['price'] * 1.2, 3, '.', ' '); ?>
                                    DT</span><?php endif; ?>
                        </div>

                        <p class="pcard-stock in-stock">En stock</p>
                        <p class="pcard-brand"><?php echo htmlspecialchars($product['brand']); ?></p>

                        <a href="products.php?add_to_cart=<?php echo $product['id']; ?>" class="pcard-btn">
                            Ajouter Au Panier
                        </a>
                        <a href="product-details.php?id=<?php echo $product['id']; ?>"
                            style="display: block; text-align: center; margin-top: 8px; font-size: 0.8rem; color: #888; font-weight: 700;">Voir
                            le produit →</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>