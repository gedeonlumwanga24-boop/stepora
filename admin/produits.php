<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// ------------------------
// Gestion du formulaire ajout
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $categorie = trim($_POST['categorie'] ?? '');
    $tailles = $_POST['tailles'] ?? [];

    // Répertoire upload images → public/images/
    $uploadDir = __DIR__ . '/../public/images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $imagesArray = [];

    // Image principale
    if (!empty($_FILES['image_principale']['name'])) {
        $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['image_principale']['name']));
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
                $imgName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['images']['name'][$key]));
                $imgPath = $uploadDir . $imgName;
                if (move_uploaded_file($tmpName, $imgPath)) {
                    $imagesArray[] = $imgName;
                }
            }
        }
    }

    $imagesString = implode(',', $imagesArray);
    $taillesString = implode(',', array_keys(array_filter($tailles, fn($stock)=>$stock>0)));

    // Insertion dans la BD
    $stmt = $conn->prepare("
        INSERT INTO produits 
        (nom, description, prix, categorie, image_principale, images, tailles) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$nom, $description, $prix, $categorie, $image_principale ?? '', $imagesString, $taillesString]);

    $success = "Produit ajouté avec succès !";
}

// Récupération des produits
$stmt = $conn->prepare("SELECT * FROM produits ORDER BY created_at DESC");
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Produits</title>
<link rel="stylesheet" href="css/admin.css">
<style>
/* ====== CSS FORMULAIRE ====== */
.form-admin {
    background: #fff;
    padding: 20px 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.form-admin label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.form-admin input[type="text"],
.form-admin input[type="number"],
.form-admin textarea,
.form-admin input[type="file"] {
    width: 100%;
    padding: 7px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.form-admin textarea {
    min-height: 80px;
    resize: vertical;
}

.tailles-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 5px;
}

.tailles-container label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-weight: normal;
}

button[type="submit"] {
    margin-top: 15px;
    padding: 12px 25px;
    background-color: #2c3e50;
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

button[type="submit"]:hover {
    background-color: #34495e;
}

/* ====== TABLE PRODUITS ====== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: #fff;
}

th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}

th {
    background-color: #2c3e50;
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

.btn {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
}

.btn.edit { background: #3498db; color: #fff; }
.btn.delete { background: #e74c3c; color: #fff; }

</style>
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
        <h1>👟 Gestion des produits</h1>

        <!-- LISTE DES PRODUITS -->
        <h2>📦 Produits existants</h2>
        <?php if(count($produits) === 0): ?>
            <p>Aucun produit pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Tailles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($produits as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nom']) ?></td>
                        <td><?= number_format($p['prix'],2,',',' ') ?> CDF</td>
                        <td><?= htmlspecialchars($p['categorie']) ?></td>
                        <td><?= htmlspecialchars($p['tailles']) ?></td>
                        <td>
                            <a href="edit_produit.php?id=<?= $p['id'] ?>" class="btn edit">✏️ Modifier</a>
                            <a href="delete_produit.php?id=<?= $p['id'] ?>" class="btn delete" onclick="return confirm('Supprimer ce produit ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- FORMULAIRE AJOUT -->
        <h2>➕ Ajouter un nouveau produit</h2>
        <?php if(!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="form-admin">
            <input type="hidden" name="add_product" value="1">

            <label>Nom :</label>
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
                    <label><?= $t ?> : <input type="number" name="tailles[<?= $t ?>]" value="0" min="0"></label>
                <?php endforeach; ?>
            </div>

            <button type="submit">Ajouter le produit</button>
        </form>

    </main>
</div>

</body>
</html>
