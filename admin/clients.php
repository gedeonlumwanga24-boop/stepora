<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

/* 🔐 Sécurité admin */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ================= ACTIONS ================= */
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'supprimer') {
    $id = (int) $_GET['id'];

    // Sécurité : éviter supprimer soi-même si admin est aussi client
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: clients.php");
    exit;
}

/* ================= LISTE DES CLIENTS ================= */
$clients = $conn->query(
    "SELECT id, nom, email, created_at 
     FROM clients 
     ORDER BY created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Clients</title>
<link rel="stylesheet" href="css/admin.css">


</head>
<body>

<div class="admin-container">

    <!-- MENU LATÉRAL -->
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

    <!-- CONTENU -->
    <main class="content">
        <h1>👤 Clients inscrits</h1>
        <p>Liste de toutes les personnes ayant créé un compte :</p>

        <?php if (count($clients) === 0): ?>
            <p>Aucun client inscrit pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Date d’inscription</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $c): ?>
<tr>
    <td data-label="ID">#<?= $c['id'] ?></td>
    <td data-label="Nom"><?= htmlspecialchars($c['nom']) ?></td>
    <td data-label="Email">
        <?= htmlspecialchars($c['email']) ?>
        <a href="mailto:<?= htmlspecialchars($c['email']) ?>?subject=Contact depuis Stepora"
           style="margin-left:10px; padding:5px 10px; background:#3498db; color:#fff; border-radius:4px; text-decoration:none; font-size:0.9rem;">
            📧 Contacter
        </a>
    </td>

    <td data-label="Date">
        <?= date('d/m/Y H:i', strtotime($c['created_at'])) ?>
    </td>
    <td data-label="Action">
        <a href="?action=supprimer&id=<?= $c['id'] ?>"
           class="btn delete"
           onclick="return confirm('Supprimer ce client ?')">
           Supprimer
        </a>
    </td>
</tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>

</body>
</html>
