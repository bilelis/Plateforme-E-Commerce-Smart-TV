<?php
include 'includes/db.php';

if (empty($_SESSION['cart'])) {
    header("Location: products.php");
    exit;
}

$success = false;
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Insertion commande principale
    $q1 = "INSERT INTO orders (client_name, phone, address, total_price) VALUES ('$name', '$phone', '$address', '$total')";
    if (mysqli_query($conn, $q1)) {
        $order_id = mysqli_insert_id($conn);

        // Insertion détails produits
        foreach ($_SESSION['cart'] as $item) {
            $pid = intval($item['id']);
            $qty = intval($item['quantity']);
            $prc = floatval($item['price']);
            $q2 = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $pid, $qty, $prc)";
            mysqli_query($conn, $q2);
        }

        // Vider le panier et succès
        $_SESSION['cart'] = [];
        $success = true;
    }
}

include 'includes/header.php';
?>

<div class="container" style="padding: 100px 0;">
    <div style="max-width: 600px; margin: 0 auto;">
        <h1 style="text-align: center; font-size: 2.2rem; font-weight: 900; margin-bottom: 40px;">Finaliser <span>Ma Commande</span></h1>

        <?php if ($success): ?>
            <div style="background: #fff; padding: 56px; border-radius: 20px; border: 1.5px solid #eee; text-align: center;">
                <div style="width: 80px; height: 80px; background: #22c55e; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                    <svg viewBox="0 0 24 24" style="width: 40px; height: 40px; fill: #fff;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                </div>
                <h2 style="font-weight: 900; font-size: 1.8rem; margin-bottom: 16px;">Commande Confirmée</h2>
                <p style="color: #666; margin-bottom: 32px; font-size: 1.05rem;">Merci pour votre confiance. Votre commande <strong>#<?php echo $order_id; ?></strong> est enregistrée. Nous vous contacterons prochainement pour la livraison.</p>
                <a href="index.php" class="btn-accent" style="padding: 16px 40px; font-size: 1.1rem;">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <div class="form-container">
                <form method="POST">
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Nom Complet</label>
                        <input type="text" name="name" required placeholder="Ex: Ahmed Ayari" style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;" onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Numéro de Téléphone</label>
                        <input type="tel" name="phone" required placeholder="Ex: 50 123 456" style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;" onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Adresse de Livraison</label>
                        <textarea name="address" required placeholder="Ex: Rue 123, Tunis, Tunisie" style="width: 100%; min-height: 120px; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; resize: vertical; transition: border 0.3s;" onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'"></textarea>
                    </div>

                    <div style="background: #f8f9fc; padding: 24px; border-radius: 12px; margin-top: 32px; margin-bottom: 32px; border: 1.5px solid #eee;">
                        <div style="display: flex; justify-content: space-between; font-weight: 900; font-size: 1.25rem;">
                            <span>Total à payer</span>
                            <span style="color: #ff6600;"><?php echo number_format($total, 3, '.', ' '); ?> <small style="font-size: 0.8rem;">DT</small></span>
                        </div>
                        <p style="font-size: 0.85rem; color: #888; margin-top: 8px; font-weight: 600;">Paiement à la livraison en espèces ou par chèque.</p>
                    </div>

                    <button type="submit" style="width: 100%; padding: 18px; font-size: 1.1rem; background: #1d9ce8; color: #fff; border: none; border-radius: 12px; font-weight: 900; cursor: pointer; transition: background 0.3s; font-family: 'Nunito', sans-serif;" onmouseover="this.style.background='#1580c5'" onmouseout="this.style.background='#1d9ce8'">Confirmer la commande</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>