<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $categorie = trim($_POST['categorie'] ?? '');
    $tailles = $_POST['tailles'] ?? [];

    $uploadDir = 'images/';
    $imagesArray = [];

    // Image principale
    if (!empty($_FILES['image_principale']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image_principale']['name']);
        $imagePath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $imagePath)) {
            $image_principale = $imageName;
            $imagesArray[] = $imageName;
        }
    }

    // Images supplémentaires
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['images']['error'][$key] === 0) {
                $imgName = time() . '_' . basename($_FILES['images']['name'][$key]);
                $imgPath = $uploadDir . $imgName;
                if (move_uploaded_file($tmpName, $imgPath)) {
                    $imagesArray[] = $imgName;
                }
            }
        }
    }

    $imagesString = implode(',', $imagesArray);
    $taillesString = implode(',', array_keys(array_filter($tailles, fn($stock)=>$stock>0)));

    $stmt = $conn->prepare("
        INSERT INTO produits 
        (nom, description, prix, categorie, image_principale, images, tailles) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nom, $description, $prix, $categorie, $image_principale ?? '', $imagesString, $taillesString]);

    $success = "Produit ajouté avec succès !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Ajouter Produit</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2>STEPORA Admin</h2>
        <nav>
            <a href="dashboard.php">📊 Dashboard</a>
            <a href="clients.php" class="active">👤 Clients</a>
            <a href="messages.php">📬 Messages</a>
            <a href="produits.php">👟 Produits</a>
            <a href="commandes.php">📦 Commandes</a>
            <a href="stats.php">📊  Statistiques</a>
            <a href="ajouter_admin.php" class="active">➕ Ajouter admin</a>
            <a href="logout.php" class="logout">⏏ Déconnexion</a>
        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        <h1>➕ Ajouter un produit</h1>

        <?php if(!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="form-admin">
            <label>Nom de la paire :</label>
            <input type="text" name="nom" required>

            <label>Description :</label>
            <textarea name="description"></textarea>

            <label>Prix :</label>
            <input type="number" name="prix" step="0.01" required>

            <label>Catégorie :</label>
            <input type="text" name="categorie">

            <label>Image principale :</label>
            <input type="file" name="image_principale" accept="image/*" required>

            <label>Images supplémentaires :</label>
            <input type="file" name="images[]" multiple accept="image/*">

            <label>Tailles disponibles :</label>
            <div class="tailles-container">
                <?php 
                $defaultTailles = ['38','39','40','41','42','43','44'];
                foreach($defaultTailles as $t): ?>
                    <label>
                        <?= $t ?> :
                        <input type="number" name="tailles[<?= $t ?>]" value="0" min="0">
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Ajouter le produit</button>
        </form>
    </main>
</div>

</body>
</html>
