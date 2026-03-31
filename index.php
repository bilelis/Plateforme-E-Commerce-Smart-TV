<?php
include 'includes/db.php';
include 'includes/header.php';

// Produits phares (Top 4)
$query = "SELECT * FROM products LIMIT 4";
$result = mysqli_query($conn, $query);
?>

<section class="hero">
    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 60px;">
        <div>
            <h1 style="font-size: 3.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 24px;">L'innovation
                <span>Smart TV</span> en Tunisie
            </h1>
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 40px;">Découvrez des images d'une pureté
                exceptionnelle avec notre nouvelle gamme OLED et QLED. Livraison gratuite sur tout le territoire.</p>
            <div style="display: flex; gap: 16px;">
                <a href="products.php" class="btn-accent">Découvrir le catalogue</a>
                <a href="#featured"
                    style="padding: 12px 24px; font-weight: 800; border: 1.5px solid #eee; border-radius: 10px;">Promotions</a>
            </div>
        </div>
        <div>
            <img src="assets/images/index.jpg"
                style="width: 100%; border-radius: 20px; box-shadow: 0 40px 100px rgba(0,0,0,0.2);">
        </div>
    </div>
</section>

<section id="featured" style="padding-bottom: 100px;">
    <div class="container">
        <div class="section-head">
            <h1>Nos <span>Ventes</span> Flash</h1>
            <p>Saisissez l'opportunité avec nos meilleures offres actuelles</p>
        </div>

        <div class="grid">
            <?php while ($product = mysqli_fetch_assoc($result)):
                $isPromo = ($product['id'] % 2 == 0);
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
                                    class="pcard-old-price"><?php echo number_format($product['price'] * 1.15, 3, '.', ' '); ?>
                                    DT</span><?php endif; ?>
                        </div>

                        <p class="pcard-stock in-stock">En stock</p>
                        <p class="pcard-brand"><?php echo htmlspecialchars($product['brand']); ?></p>

                        <a href="products.php?add_to_cart=<?php echo $product['id']; ?>" class="pcard-btn">
                            Ajouter Au Panier
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>