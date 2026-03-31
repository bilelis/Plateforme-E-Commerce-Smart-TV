<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

// Stats
$orders_q = mysqli_query($conn, "SELECT COUNT(*) as count, SUM(total_price) as revenue FROM orders");
$orders_data = mysqli_fetch_assoc($orders_q);

$products_q = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
$products_data = mysqli_fetch_assoc($products_q);

// Best Sellers
$best_sellers_q = mysqli_query($conn, "
    SELECT p.name, SUM(oi.quantity) as total_sold
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    GROUP BY p.id
    ORDER BY total_sold DESC
    LIMIT 5
");

// Recent Orders
$recent_orders_q = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 5");

include '../includes/header.php';
?>

<div style="display: flex; min-height: calc(100vh - 72px); background: #f4f6fb;">
    <aside style="width: 260px; background: #fff; border-right: 1.5px solid #eee; padding: 40px 0;">
        <div style="padding: 0 32px; margin-bottom: 40px;">
            <p
                style="font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase; letter-spacing: 1px;">
                Administration</p>
        </div>
        <nav style="display: flex; flex-direction: column;">
            <a href="dashboard.php"
                style="padding: 16px 32px; font-weight: 800; color: #1d9ce8; background: #f0f7ff; border-right: 4px solid #1d9ce8;">Espace
                de Travail</a>
            <a href="products.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Inventaire</a>
            <a href="users.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Utilisateurs</a>
            <a href="../logout.php"
                style="padding: 16px 32px; font-weight: 800; color: #ef4444; margin-top: 40px;">Déconnexion</a>
        </nav>
    </aside>

    <main style="flex: 1; padding: 60px;">
        <h2 style="margin-bottom: 40px; font-size: 2.2rem; font-weight: 900;">Tableau de <span>Bord</span></h2>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;">
            <div
                style="background: #fff; padding: 32px; border-radius: 16px; border: 1.5px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                <p
                    style="font-size: 0.85rem; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 8px;">
                    Commandes Totales</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: #1a1a2e;"><?php echo $orders_data['count']; ?>
                </h3>
            </div>
            <div
                style="background: #fff; padding: 32px; border-radius: 16px; border: 1.5px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                <p
                    style="font-size: 0.85rem; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 8px;">
                    Chiffre d'Affaires</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: #ff6600;">
                    <?php echo number_format($orders_data['revenue'] ?? 0, 3, '.', ' '); ?> <small
                        style="font-size: 1rem;">TND</small>
                </h3>
            </div>
            <div
                style="background: #fff; padding: 32px; border-radius: 16px; border: 1.5px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                <p
                    style="font-size: 0.85rem; font-weight: 800; color: #888; text-transform: uppercase; margin-bottom: 8px;">
                    Produits en Stock</p>
                <h3 style="font-size: 2.5rem; font-weight: 900; color: #1d9ce8;"><?php echo $products_data['count']; ?>
                </h3>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
            <div>
                <h3 style="margin-bottom: 24px; font-size: 1.1rem; font-weight: 800; color: #1a1a2e;">Commandes Récentes
                </h3>
                <div style="background: #fff; border-radius: 16px; border: 1.5px solid #eee; overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead style="background: #f8f9fc;">
                            <tr>
                                <th
                                    style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                                    ID</th>
                                <th
                                    style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                                    Client</th>
                                <th
                                    style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                                    Montant</th>
                                <th
                                    style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                                    Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($o = mysqli_fetch_assoc($recent_orders_q)): ?>
                                <tr style="border-bottom: 1.5px solid #f8f9fc;">
                                    <td style="padding: 20px; font-weight: 800; color: #888;">#<?php echo $o['id']; ?></td>
                                    <td style="padding: 20px; font-weight: 700; color: #1a1a2e;">
                                        <?php echo htmlspecialchars($o['client_name']); ?>
                                    </td>
                                    <td style="padding: 20px; font-weight: 900; color: #1d9ce8;">
                                        <?php echo number_format($o['total_price'], 3, '.', ' '); ?> <small>DT</small>
                                    </td>
                                    <td style="padding: 20px;">
                                        <span
                                            style="background: rgba(34,197,94,0.1); color: #22c55e; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">CONFIRMÉ</span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h3 style="margin-bottom: 24px; font-size: 1.1rem; font-weight: 800; color: #1a1a2e;">Top Ventes</h3>
                <div style="background: #fff; padding: 32px; border-radius: 16px; border: 1.5px solid #eee;">
                    <?php while ($bs = mysqli_fetch_assoc($best_sellers_q)): ?>
                        <div style="margin-bottom: 24px;">
                            <div
                                style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 8px;">
                                <span
                                    style="font-weight: 700; width: 140px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #1a1a2e;"><?php echo htmlspecialchars($bs['name']); ?></span>
                                <span style="font-weight: 900; color: #ff6600;"><?php echo $bs['total_sold']; ?></span>
                            </div>
                            <div style="height: 8px; background: #f8f9fc; border-radius: 4px; position: relative;">
                                <?php $w = min(100, $bs['total_sold'] * 10); ?>
                                <div
                                    style="position: absolute; left: 0; top: 0; bottom: 0; background: #ff6600; border-radius: 4px; width: <?php echo $w; ?>%; transition: width 1s;">
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>