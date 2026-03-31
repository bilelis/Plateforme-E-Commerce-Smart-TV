<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

// Delete product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: products.php");
    exit;
}

$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);

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
            <a href="dashboard.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Espace de Travail</a>
            <a href="products.php"
                style="padding: 16px 32px; font-weight: 800; color: #1d9ce8; background: #f0f7ff; border-right: 4px solid #1d9ce8;">Inventaire</a>
            <a href="users.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Utilisateurs</a>
            <a href="../logout.php"
                style="padding: 16px 32px; font-weight: 800; color: #ef4444; margin-top: 40px;">Déconnexion</a>
        </nav>
    </aside>

    <main style="flex: 1; padding: 60px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h2 style="font-size: 2.2rem; font-weight: 900;">Gestion <span>Inventaire</span></h2>
            <a href="add-product.php"
                style="background: #1d9ce8; color: #fff; padding: 12px 24px; border-radius: 10px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: #fff;">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Nouveau Produit
            </a>
        </div>

        <div style="background: #fff; border-radius: 16px; border: 1.5px solid #eee; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #f8f9fc;">
                    <tr>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Visuel</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Référence</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Marque</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Prix (TND)</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = mysqli_fetch_assoc($result)): ?>
                        <tr style="border-bottom: 1.5px solid #f8f9fc; transition: background 0.3s;"
                            onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px;">
                                <img src="../assets/images/<?php echo $p['image']; ?>"
                                    onerror="this.src='https://placehold.co/100x70/f4f6fb/999?text=TV'"
                                    style="width: 60px; height: 45px; border-radius: 8px; border: 1px solid #eee; object-fit: contain; padding: 4px; background: #fff;">
                            </td>
                            <td style="padding: 20px; font-weight: 800; color: #1a1a2e; font-size: 0.95rem;">
                                <?php echo htmlspecialchars($p['name']); ?>
                            </td>
                            <td style="padding: 20px;">
                                <span
                                    style="display: inline-block; padding: 6px 12px; border-radius: 6px; background: #f0f7ff; color: #1d9ce8; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">
                                    <?php echo htmlspecialchars($p['brand']); ?>
                                </span>
                            </td>
                            <td style="padding: 20px; font-weight: 900; color: #ff6600; font-size: 1.05rem;">
                                <?php echo number_format($p['price'], 3, '.', ' '); ?>
                            </td>
                            <td style="padding: 20px;">
                                <div style="display: flex; gap: 16px; align-items: center;">
                                    <a href="edit-product.php?id=<?php echo $p['id']; ?>"
                                        style="font-size: 0.85rem; font-weight: 800; color: #666;">Modifier</a>
                                    <a href="products.php?delete=<?php echo $p['id']; ?>"
                                        style="color: #ef4444; font-size: 0.85rem; font-weight: 900;"
                                        onclick="return confirm('Attention : suppression irréversible. Confirmer ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>