<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Éviter de se supprimer soi-même
    if ($id !== $_SESSION['admin_id']) {
        mysqli_query($conn, "DELETE FROM users WHERE id = $id");
    }
    header("Location: users.php");
    exit;
}

$query = "SELECT * FROM users ORDER BY id DESC";
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
            <a href="products.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Inventaire</a>
            <a href="users.php"
                style="padding: 16px 32px; font-weight: 800; color: #1d9ce8; background: #f0f7ff; border-right: 4px solid #1d9ce8;">Utilisateurs</a>
            <a href="../logout.php"
                style="padding: 16px 32px; font-weight: 800; color: #ef4444; margin-top: 40px;">Déconnexion</a>
        </nav>
    </aside>

    <main style="flex: 1; padding: 60px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <h2 style="font-size: 2.2rem; font-weight: 900;">Gestion <span>Utilisateurs</span></h2>
            <a href="add-user.php"
                style="background: #1d9ce8; color: #fff; padding: 12px 24px; border-radius: 10px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: #fff;">
                    <path
                        d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                Ajouter
            </a>
        </div>

        <div style="background: #fff; border-radius: 16px; border: 1.5px solid #eee; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: #f8f9fc;">
                    <tr>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            ID</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Nom d'utilisateur</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Rôle</th>
                        <th
                            style="padding: 20px; font-size: 0.8rem; font-weight: 800; color: #888; text-transform: uppercase;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($u = mysqli_fetch_assoc($result)): ?>
                        <tr style="border-bottom: 1.5px solid #f8f9fc; transition: background 0.3s;"
                            onmouseover="this.style.background='#fafbfc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px; font-weight: 800; color: #888;">#
                                <?php echo $u['id']; ?>
                            </td>
                            <td style="padding: 20px; font-weight: 800; color: #1a1a2e; font-size: 0.95rem;">
                                <?php echo htmlspecialchars($u['username']); ?>
                                <?php if ($u['id'] === $_SESSION['admin_id']): ?>
                                    <span style="font-size: 0.7rem; color: #22c55e; margin-left: 8px;">(Vous)</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 20px;">
                                <span
                                    style="display: inline-block; padding: 6px 12px; border-radius: 6px; background: #fff5f0; color: #ff6600; font-size: 0.75rem; text-transform: uppercase; font-weight: 800;">
                                    <?php echo htmlspecialchars($u['role']); ?>
                                </span>
                            </td>
                            <td style="padding: 20px;">
                                <div style="display: flex; gap: 16px; align-items: center;">
                                    <a href="edit-user.php?id=<?php echo $u['id']; ?>"
                                        style="font-size: 0.85rem; font-weight: 800; color: #666;">Modifier</a>
                                    <?php if ($u['id'] !== $_SESSION['admin_id']): ?>
                                        <a href="users.php?delete=<?php echo $u['id']; ?>"
                                            style="color: #ef4444; font-size: 0.85rem; font-weight: 900;"
                                            onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                                    <?php endif; ?>
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