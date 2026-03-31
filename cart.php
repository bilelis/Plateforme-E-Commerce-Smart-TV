<?php
include 'includes/db.php';

// Actions panier
if (isset($_GET['action'])) {
    $id = intval($_GET['id']);
    foreach ($_SESSION['cart'] as $k => &$c) {
        if ($c['id'] == $id) {
            if ($_GET['action'] == 'plus')
                $c['quantity']++;
            if ($_GET['action'] == 'minus') {
                if ($c['quantity'] > 1) {
                    $c['quantity']--;
                } else {
                    unset($_SESSION['cart'][$k]);
                }
            }
            if ($_GET['action'] == 'del')
                unset($_SESSION['cart'][$k]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

include 'includes/header.php';
$total = 0;
?>

<div style="padding: 100px 0;">
    <div class="container">
        <h1
            style="font-size: 2.2rem; font-weight: 900; margin-bottom: 48px; border-bottom: 2px solid #eee; padding-bottom: 20px;">
            Mon <span>Panier</span></h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <div
                style="background: #fff; padding: 120px 40px; text-align: center; border-radius: 20px; border: 1.5px solid #eee;">
                <h2 style="font-size: 1.6rem; color: #666; margin-bottom: 16px;">Votre panier est vide</h2>
                <p style="color: #aaa; margin-bottom: 40px;">Découvrez nos produits exceptionnels et commencez vos achats.
                </p>
                <a href="products.php" class="btn-accent" style="padding: 16px 40px;">Parcourir le catalogue</a>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 60px;">
                <div style="background: #fff; border-radius: 20px; border: 1.5px solid #eee; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8f9fc;">
                            <tr>
                                <th style="padding: 24px; text-align: left; font-size: 0.8rem; text-transform: uppercase;">
                                    Produit</th>
                                <th
                                    style="padding: 24px; text-align: center; font-size: 0.8rem; text-transform: uppercase;">
                                    Quantité</th>
                                <th style="padding: 24px; text-align: right; font-size: 0.8rem; text-transform: uppercase;">
                                    Total</th>
                                <th style="padding: 24px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $item):
                                $stotal = $item['price'] * $item['quantity'];
                                $total += $stotal;
                                ?>
                                <tr style="border-bottom: 1.5px solid #f8f9fc;">
                                    <td style="padding: 24px; display: flex; align-items: center; gap: 20px;">
                                        <img src="assets/images/<?php echo $item['image']; ?>"
                                            onerror="this.src='https://placehold.co/100x70/f4f6fb/999?text=TV'"
                                            style="width: 100px; border-radius: 12px; border: 1px solid #eee;">
                                        <div>
                                            <p style="font-weight: 800; font-size: 0.95rem; margin-bottom: 4px;">
                                                <?php echo htmlspecialchars($item['name']); ?></p>
                                            <p style="color: #ff6600; font-weight: 700; font-size: 0.85rem;">
                                                <?php echo number_format($item['price'], 3, '.', ' '); ?> DT</p>
                                        </div>
                                    </td>
                                    <td style="padding: 24px; text-align: center;">
                                        <div
                                            style="display: inline-flex; align-items: center; background: #f8f9fc; padding: 8px; border-radius: 10px; border: 1px solid #eee;">
                                            <a href="cart.php?action=minus&id=<?php echo $item['id']; ?>"
                                                style="padding: 0 12px; font-weight: 900; color: #1d9ce8;">&minus;</a>
                                            <span
                                                style="min-width: 24px; font-weight: 900; font-size: 1.1rem; text-align: center;"><?php echo $item['quantity']; ?></span>
                                            <a href="cart.php?action=plus&id=<?php echo $item['id']; ?>"
                                                style="padding: 0 12px; font-weight: 900; color: #1d9ce8;">&plus;</a>
                                        </div>
                                    </td>
                                    <td
                                        style="padding: 24px; text-align: right; font-weight: 900; font-size: 1.1rem; color: #1a1a2e;">
                                        <?php echo number_format($stotal, 3, '.', ' '); ?> <small
                                            style="font-size: 0.7rem;">DT</small></td>
                                    <td style="padding: 24px; text-align: right;">
                                        <a href="cart.php?action=del&id=<?php echo $item['id']; ?>"
                                            style="color: #ef4444; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div>
                    <div style="background: #fff; padding: 40px; border-radius: 20px; border: 1.5px solid #eee;">
                        <h3
                            style="font-weight: 900; font-size: 1.2rem; margin-bottom: 32px; border-bottom: 1.5px solid #f8f9fc; padding-bottom: 20px;">
                            Résumé</h3>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 20px; color: #888; font-weight: 700;">
                            <span>Sous-total</span>
                            <span><?php echo number_format($total, 3, '.', ' '); ?> DT</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 32px; color: #888; font-weight: 700;">
                            <span>Livraison</span>
                            <span style="color: #22c55e;">GRATUITE</span>
                        </div>

                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 40px; font-size: 1.5rem; font-weight: 900; border-top: 1.5px solid #f8f9fc; padding-top: 24px;">
                            <span>TOTAL</span>
                            <span style="color: #ff6600;"><?php echo number_format($total, 3, '.', ' '); ?> <small
                                    style="font-size: 0.8rem;">DT</small></span>
                        </div>

                        <a href="checkout.php" class="btn-accent"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 18px; font-size: 1.1rem;">
                            Finaliser la commande
                        </a>
                        <a href="products.php"
                            style="display: block; text-align: center; margin-top: 16px; font-weight: 800; font-size: 0.85rem; color: #1d9ce8;">Retourner
                            au catalogue</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>