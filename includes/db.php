<?php
// Configuration base de données
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ayari_tn';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialisation de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialisation du panier si inexistant
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fonction utilitaire pour le comptage du panier
function getCartCount()
{
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}
?>