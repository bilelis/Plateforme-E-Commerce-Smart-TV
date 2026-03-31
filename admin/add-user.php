<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Ce nom d'utilisateur existe déjà.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $q = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', '$role')";
            if (mysqli_query($conn, $q)) {
                header("Location: users.php");
                exit;
            }
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
            <a href="products.php" style="padding: 16px 32px; font-weight: 800; color: #666;">Inventaire</a>
            <a href="users.php"
                style="padding: 16px 32px; font-weight: 800; color: #1d9ce8; background: #f0f7ff; border-right: 4px solid #1d9ce8;">Utilisateurs</a>
            <a href="../logout.php"
                style="padding: 16px 32px; font-weight: 800; color: #ef4444; margin-top: 40px;">Déconnexion</a>
        </nav>
    </aside>

    <main style="flex: 1; padding: 60px;">
        <div style="max-width: 600px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 40px;">
                <a href="users.php"
                    style="width: 40px; height: 40px; background: #fff; border: 1.5px solid #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #888; transition: border 0.3s;"
                    onmouseover="this.style.borderColor='#1d9ce8'" onmouseout="this.style.borderColor='#eee'">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: currentColor;">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
                    </svg>
                </a>
                <h2 style="font-size: 2.2rem; font-weight: 900;">Nouvel <span>Utilisateur</span></h2>
            </div>

            <?php if ($error): ?>
                <div
                    style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 16px; border-radius: 10px; font-weight: 700; margin-bottom: 24px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div
                style="background: #fff; padding: 48px; border-radius: 20px; border: 1.5px solid #eee; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                <form method="POST">
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Nom
                            d'utilisateur</label>
                        <input type="text" name="username" required placeholder="Nouveau login"
                            style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                            onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label
                            style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Rôle</label>
                        <select name="role" required
                            style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s; background: #fff;"
                            onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                            <option value="admin">Administrateur</option>
                            <option value="moderator">Modérateur</option>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                        <div>
                            <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Mot
                                de passe</label>
                            <input type="password" name="password" required
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                        <div>
                            <label
                                style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px;">Confirmer</label>
                            <input type="password" name="confirm_password" required
                                style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
                        </div>
                    </div>

                    <div style="display: flex; gap: 16px; border-top: 1.5px solid #eee; padding-top: 32px;">
                        <button type="submit"
                            style="padding: 16px 40px; font-size: 1.05rem; background: #1d9ce8; color: #fff; border: none; border-radius: 10px; font-weight: 900; cursor: pointer; transition: background 0.3s; font-family: 'Nunito', sans-serif;"
                            onmouseover="this.style.background='#1580c5'"
                            onmouseout="this.style.background='#1d9ce8'">Créer l'utilisateur</button>
                        <a href="users.php"
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