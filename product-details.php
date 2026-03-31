<?php
include 'includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$p = mysqli_fetch_assoc($res);

if (!$p) {
    header("Location: products.php");
    exit();
}

include 'includes/header.php';
?>

<div style="background: #fff; border-bottom: 1px solid #eee; padding: 60px 0;">
    <div class="container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start;">
        <div
            style="background: #f8f9fc; border-radius: 20px; padding: 40px; display: flex; align-items: center; justify-content: center; position: relative;">
            <img src="assets/images/<?php echo $p['image']; ?>"
                onerror="this.src='https://placehold.co/800x600/f4f6fb/999?text=Smart+TV'"
                style="width: 100%; object-fit: contain;">
            <div
                style="position: absolute; top: 24px; right: 24px; background: #ff6600; color: #fff; padding: 8px 16px; border-radius: 50px; font-weight: 900; font-size: 0.75rem;">
                GARANTIE 5 ANS</div>
        </div>

        <div>
            <p
                style="color: #888; font-weight: 700; margin-bottom: 12px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                <?php echo htmlspecialchars($p['brand']); ?></p>
            <h1 style="font-size: 2.8rem; font-weight: 900; line-height: 1.2; margin-bottom: 24px;">
                <?php echo htmlspecialchars($p['name']); ?></h1>
            <p style="color: #aaa; font-weight: 600; font-size: 0.85rem; margin-bottom: 32px;">Référence : <span
                    style="color: #333;">REF-<?php echo $p['id']; ?></span></p>

            <div style="display: flex; align-items: baseline; gap: 16px; margin-bottom: 40px;">
                <span
                    style="font-size: 3rem; font-weight: 900; color: #ff6600;"><?php echo number_format($p['price'], 3, '.', ' '); ?>
                    <small style="font-size: 1rem;">DT</small></span>
                <span style="color: #22c55e; font-weight: 800; font-size: 0.9rem;">En stock</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px;">
                <div style="background: #f8f9fc; padding: 20px; border-radius: 12px; border: 1.5px solid #eee;">
                    <p style="color: #888; font-size: 0.75rem; font-weight: 700; margin-bottom: 4px;">ÉCRAN</p>
                    <p style="font-weight: 800;"><?php echo $p['size']; ?> Pouces</p>
                </div>
                <div style="background: #f8f9fc; padding: 20px; border-radius: 12px; border: 1.5px solid #eee;">
                    <p style="color: #888; font-size: 0.75rem; font-weight: 700; margin-bottom: 4px;">TECHNOLOGIE</p>
                    <p style="font-weight: 800;">Smart TV LED 4K</p>
                </div>
            </div>

            <p style="color: #555; line-height: 1.8; font-size: 1.05rem; margin-bottom: 48px;">
                <?php echo nl2br(htmlspecialchars($p['description'])); ?>
            </p>

            <div style="display: flex; gap: 16px;">
                <a href="products.php?add_to_cart=<?php echo $p['id']; ?>" class="btn-accent"
                    style="padding: 18px 48px; font-size: 1.1rem; display: flex; align-items: center; gap: 12px;">
                    <svg style="width: 20px; height: 20px; fill: #fff;" viewBox="0 0 24 24">
                        <path
                            d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-14.5-16H.5C.22 2 0 2.22 0 2.5s.22.5.5.5H2l3.6 7.59L4.25 13C4.09 13.32 4 13.65 4 14c0 1.1.9 2 2 2h13c.55 0 1-.45 1-1s-.45-1-1-1H6.42c-.14 0-.25-.11-.25-.25l.03-.12L7.1 13H19c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 23.46 4H5.21L4.54 2H2.5c-.28 0-.5.22-.5.5S2.22 3 2.5 3H3.3l.2.5z" />
                    </svg>
                    Ajouter Au Panier
                </a>
            </div>
        </div>
    </div>
</div>

<section style="padding: 100px 0;">
    <div class="container">
        <h2 style="text-align: center; font-weight: 900; margin-bottom: 60px;">Spécifications <span>Détaillées</span>
        </h2>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;">
            <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1.5px solid #eee;">
                <h4 style="color: #ff6600; margin-bottom: 16px;">Qualité d'image</h4>
                <p style="color: #666; font-size: 0.95rem;">Contraste dynamique, HDR 10+ et moteur de traitement d'image
                    haute performance pour un rendu ultra-réaliste.</p>
            </div>
            <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1.5px solid #eee;">
                <h4 style="color: #ff6600; margin-bottom: 16px;">Smart Ecosystem</h4>
                <p style="color: #666; font-size: 0.95rem;">Interface intuitive, accès direct à Netflix, YouTube, Prime
                    Video et bien plus encore.</p>
            </div>
            <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1.5px solid #eee;">
                <h4 style="color: #ff6600; margin-bottom: 16px;">Son Immersif</h4>
                <p style="color: #666; font-size: 0.95rem;">Système audio Dolby Digital avec optimisation spatiale pour
                    une immersion totale.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>