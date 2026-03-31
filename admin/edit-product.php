<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

$id = intval($_GET['id']);
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

if (!$p) {
    header("Location: products.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $price = floatval($_POST['price']);
    $size = intval($_POST['size']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image_name = $p['image']; // garder l'ancienne par défaut

    // Gestion de l'image (optionnel)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $image_name = uniqid('tv_') . '.' . $ext;
            $upload_path = '../assets/images/' . $image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);
        } else {
            $error = "Format d'image non valide.";
        }
    }

    if (!$error) {
        $q = "UPDATE products SET name='$name', brand='$brand', price=$price, size=$size, image='$image_name', description='$description' WHERE id=$id";
        if (mysqli_query($conn, $q)) {
            header("Location: products.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    }
}

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
        <div style="max-width: 800px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 40px;">
                <a href="products.php"
                    style="width: 40px; height: 40px; background: #fff; border: 1.5px solid #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #888; transition: border 0.3s;"
                    onmouseover="this.style.borderColor='#1d9ce8'" onmouseout="this.style.borderColor='#eee'">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                </a>
                <h2 style="font-size: 2.2rem; font-weight: 900;">Modification <span>#<?php echo $id; ?></span></h2>
            </div>

            <?php if ($error): ?>
                <div
                    style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 16px; border-radius: 10px; font-weight: 700; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div
                style="background: #fff; padding: 48px; border-radius: 20px; border: 1.5px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label
                                style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Désignation
                                du modèle</label>
                            <input type="text" name="name" required value="<?php echo htmlspecialchars($p['name']); ?>"
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                        <div>
                            <label
                                style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Marque</label>
                            <input type="text" name="brand" required
                                value="<?php echo htmlspecialchars($p['brand']); ?>"
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div>
                            <label
                                style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Prix
                                de vente (TND)</label>
                            <input type="number" step="0.001" name="price" required value="<?php echo $p['price']; ?>"
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                        <div>
                            <label
                                style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Taille
                                d'écran (Pouces)</label>
                            <input type="number" name="size" required value="<?php echo $p['size']; ?>"
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Image
                            du produit (Laissez vide pour conserver)</label>
                        <input type="file" name="image" accept="image/*"
                            style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s; background: #fafbfc;"
                            onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        <p style="font-size: 0.8rem; color: #888; margin-top: 8px;">Actuelle:
                            <?php echo htmlspecialchars($p['image']); ?>
                        </p>
                    </div>

                    <div style="margin-bottom: 32px;">
                        <label
                            style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Description
                            technique</label>
                        <textarea name="description" required
                            style="width: 100%; min-height: 150px; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; resize: vertical; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#1d9ce8'"
                            onblur="this.style.borderColor='#eee'"><?php echo htmlspecialchars($p['description']); ?></textarea>
                    </div>

                    <div style="display: flex; gap: 16px; border-top: 1.5px solid #eee; padding-top: 32px;">
                        <button type="submit"
                            style="padding: 16px 40px; font-size: 1.05rem; background: #ff6600; color: #fff; border: none; border-radius: 10px; font-weight: 900; cursor: pointer; transition: background 0.3s; font-family: 'Nunito', sans-serif;"
                            onmouseover="this.style.background='#e65c00'"
                            onmouseout="this.style.background='#ff6600'">Mettre à jour</button>
                        <a href="products.php"
                            style="padding: 14px 40px; font-size: 1.05rem; background: #fff; color: #666; border: 1.5px solid #eee; border-radius: 10px; font-weight: 800; cursor: pointer; text-decoration: none; display: flex; align-items: center; transition: background 0.3s;"
                            onmouseover="this.style.background='#f8f9fc'"
                            onmouseout="this.style.background='#fff'">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>