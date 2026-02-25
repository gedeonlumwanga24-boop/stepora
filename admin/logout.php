<?php
session_start();
require_once "../backend/config/database.php";

if (isset($_SESSION['admin'])) {
    $db = new Database();
    $conn = $db->getConnection();

    // Met à jour le moment où l'admin se déconnecte
    $stmt = $conn->prepare("UPDATE admins SET session_end = NOW() WHERE id = ?");
    $stmt->execute([$_SESSION['admin']['id']]);
}

// Détruit la session
session_destroy();

// Redirige vers la page de connexion
header("Location: login.php");
exit;
?>











