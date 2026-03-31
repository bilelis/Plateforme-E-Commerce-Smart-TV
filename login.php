<?php
include 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_user'] = $user['username'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $error = 'Identifiants invalides.';
    }
}

include 'includes/header.php';
?>

<div style="min-height: calc(100vh - 72px); display: flex; align-items: center; justify-content: center; background: #f4f6fb;">
    <div style="background: #fff; padding: 48px; border-radius: 20px; border: 1.5px solid #eee; width: 100%; max-width: 440px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="width: 64px; height: 64px; background: #f0f7ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <svg viewBox="0 0 24 24" style="width: 32px; height: 32px; fill: #1d9ce8;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <h2 style="font-size: 1.8rem; font-weight: 900; color: #1a1a2e;">Connexion Admin</h2>
            <p style="color: #888; font-size: 0.95rem; margin-top: 8px;">Accédez à votre espace de travail</p>
        </div>

        <?php if ($error): ?>
            <div style="background: rgba(239,68,68,0.1); color: #ef4444; padding: 16px; border-radius: 10px; font-weight: 700; margin-bottom: 24px; text-align: center; border: 1px solid rgba(239,68,68,0.2);">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px; color: #1a1a2e;">Nom d'utilisateur</label>
                <input type="text" name="username" required placeholder="Ex: admin" style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;" onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
            </div>
            <div style="margin-bottom: 32px;">
                <label style="display: block; font-weight: 800; font-size: 0.95rem; margin-bottom: 8px; color: #1a1a2e;">Mot de passe</label>
                <input type="password" name="password" required placeholder="Votre mot de passe" style="width: 100%; padding: 14px 16px; border-radius: 10px; border: 1.5px solid #eee; font-family: 'Nunito', sans-serif; font-size: 1rem; outline: none; transition: border 0.3s;" onfocus="this.style.borderColor='#1d9ce8'" onblur="this.style.borderColor='#eee'">
            </div>
            <button type="submit" style="width: 100%; padding: 16px; font-size: 1.1rem; background: #1d9ce8; color: #fff; border: none; border-radius: 10px; font-weight: 900; cursor: pointer; transition: background 0.3s; font-family: 'Nunito', sans-serif;" onmouseover="this.style.background='#1580c5'" onmouseout="this.style.background='#1d9ce8'">Se connecter</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>