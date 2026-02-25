<?php
session_start();
require_once "../backend/config/database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $db = new Database();
    $conn = $db->getConnection();

    // 1️⃣ Supprimer les fichiers images du serveur
    $stmt = $conn->prepare("SELECT image_principale, images FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        $images = array_filter(array_merge(
            [$produit['image_principale']], 
            explode(',', $produit['images'])
        ));

        foreach ($images as $img) {
            $path = __DIR__ . '/../public/images/' . $img;
            if (file_exists($path)) {
                unlink($path); // supprime l'image
            }
        }

        // 2️⃣ Supprimer le produit de la BD
        $stmtDel = $conn->prepare("DELETE FROM produits WHERE id = ?");
        $stmtDel->execute([$id]);

        header("Location: produits.php");
        exit;
    }
}
header("Location: produits.php");
exit;
