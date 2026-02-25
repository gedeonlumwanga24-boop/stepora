<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$uploadDir = '../public/images/';

// ------------------------
// Récupération du produit
// ------------------------
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Produit non trouvé !");
}

$stmt = $conn->prepare("SELECT * FROM produits WHERE id=?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$produit) die("Produit introuvable !");

// ------------------------
// Traitement POST
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $categorie = trim($_POST['categorie'] ?? '');
    $tailles = $_POST['tailles'] ?? [];

    // ------------------------
    // Images existantes
    // ------------------------
    $imagesArray = $produit['images'] ? explode(',', $produit['images']) : [];

    // Supprimer images cochées
    if (!empty($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $delImg) {
            $filePath = $uploadDir . $delImg;
            if (file_exists($filePath)) unlink($filePath);
            $imagesArray = array_filter($imagesArray, fn($i) => $i !== $delImg);
        }
    }

    // ------------------------
    // Image principale
    // ------------------------
    $image_principale = $produit['image_principale'] ?? '';
    if (!empty($_POST['delete_main_image'])) {
        $mainPath = $uploadDir . $image_principale;
        if (file_exists($mainPath)) unlink($mainPath);
        $image_principale = '';
    }

    if (!empty($_FILES['image_principale']['name'])) {
        $imgName = time() . '_' . basename($_FILES['image_principale']['name']);
        $imgPath = $uploadDir . $imgName;
        if (move_uploaded_file($_FILES['image_principale']['tmp_name'], $imgPath)) {
            $image_principale = $imgName;
            $imagesArray[] = $imgName;
        }
    }

    // ------------------------
    // Images supplémentaires
    // ------------------------
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

    // ------------------------
    // Mise à jour BD
    // ------------------------
    $stmt = $conn->prepare("
        UPDATE produits
        SET nom=?, description=?, prix=?, categorie=?, image_principale=?, images=?, tailles=?
        WHERE id=?
    ");
    $stmt->execute([$nom, $description, $prix, $categorie, $image_principale, $imagesString, $taillesString, $id]);

    $success = "Produit mis à jour avec succès !";

    // Recharger le produit pour affichage
    $stmt = $conn->prepare("SELECT * FROM produits WHERE id=?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier Produit - Admin</title>
<link rel="stylesheet" href="css/admin.css">
<style>
.form-admin { max-width:700px; margin-top:20px; }
.form-admin label { display:block; margin:10px 0 4px; font-weight:bold; }
.form-admin input[type=text],
.form-admin input[type=number],
.form-admin textarea,
.form-admin input[type=file] { width:100%; padding:8px; margin-bottom:10px; border:1px solid #ccc; border-radius:4px; }
.tailles-container label { display:inline-block; margin-right:10px; margin-bottom:5px; }
.form-admin button { padding:10px 20px; background:#2c3e50; color:#fff; border:none; border-radius:4px; cursor:pointer; }
.existing-images { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:10px; }
.existing-images img { width:80px; border:1px solid #ccc; border-radius:4px; }
</style>
</head>
<body>

<div class="admin-container">
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

    <main class="content">
        <h1>✏️ Modifier le produit</h1>
        <?php if(!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="form-admin">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>

            <label>Description :</label>
            <textarea name="description"><?= htmlspecialchars($produit['description']) ?></textarea>

            <label>Prix :</label>
            <input type="number" name="prix" step="0.01" value="<?= $produit['prix'] ?>" required>

            <label>Catégorie :</label>
            <input type="text" name="categorie" value="<?= htmlspecialchars($produit['categorie']) ?>">

            <label>Image principale :</label>
            <?php if($produit['image_principale']): ?>
                <div class="existing-images">
                    <img src="../public/images/<?= $produit['image_principale'] ?>" alt="">
                    <label><input type="checkbox" name="delete_main_image"> Supprimer</label>
                </div>
            <?php endif; ?>
            <input type="file" name="image_principale" accept="image/*">

            <label>Images supplémentaires :</label>
            <div class="existing-images">
            <?php if($produit['images']): 
                $imgs = explode(',', $produit['images']);
                foreach($imgs as $img): ?>
                    <div style="text-align:center;">
                        <img src="../public/images/<?= $img ?>" alt="">
                        <label><input type="checkbox" name="delete_images[]" value="<?= $img ?>"> Supprimer</label>
                    </div>
            <?php endforeach; endif; ?>
            </div>
            <input type="file" name="images[]" multiple accept="image/*">

            <label>Tailles disponibles :</label>
            <div class="tailles-container">
                <?php 
                $defaultTailles = ['38','39','40','41','42','43','44'];
                $currentTailles = $produit['tailles'] ? explode(',', $produit['tailles']) : [];
                foreach($defaultTailles as $t): ?>
                    <label><?= $t ?> :
                        <input type="number" name="tailles[<?= $t ?>]" value="<?= in_array($t,$currentTailles)?1:0 ?>" min="0">
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Mettre à jour le produit</button>
        </form>
    </main>
</div>

</body>
</html>
