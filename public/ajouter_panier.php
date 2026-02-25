<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$id     = (int)$_POST['id'];
$taille = $_POST['taille'];

if (empty($taille)) {
    header("Location: produit.php?id=$id");
    exit;
}

$trouve = false;

foreach ($_SESSION['panier'] as &$item) {
    if ($item['id'] === $id && $item['taille'] === $taille) {
        $item['quantite']++;
        $trouve = true;
        break;
    }
}

if (!$trouve) {
    $_SESSION['panier'][] = [
        'id' => $id,
        'nom' => $_POST['nom'],
        'prix' => $_POST['prix'],
        'image' => $_POST['image'],
        'taille' => $taille,
        'quantite' => 1
    ];
}

header("Location: panier.php");
exit;
