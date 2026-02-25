<?php 
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Récupération des messages
$stmt = $conn->prepare("SELECT * FROM messages ORDER BY created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Messages</title>
<link rel="stylesheet" href="css/admin.css">
<style>
/* Tableau et boutons */
table { width:100%; border-collapse: collapse; background:#fff; margin-top:15px; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; vertical-align: middle; }
th { background:#2c3e50; color:#fff; }
a.btn-repondre { display:inline-block; padding:4px 10px; background:#3498db; color:#fff; border-radius:4px; font-size:0.85rem; text-decoration:none; margin-top:2px; }
button.delete { padding:4px 10px; background:#e74c3c; color:#fff; border:none; border-radius:4px; font-size:0.85rem; cursor:pointer; }
button.delete:hover, a.btn-repondre:hover { opacity:0.85; }

/* Responsive mobile */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr { display: block; width: 100%; }
    tr { margin-bottom: 1rem; border: 1px solid #ddd; padding: 8px; }
    td { text-align: right; padding-left: 50%; position: relative; }
    td::before { content: attr(data-label); position: absolute; left: 10px; font-weight: bold; text-align: left; }
}
</style>
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
        <h1>📬 Messages reçus</h1>
        <p>Voici tous les messages envoyés par vos clients :</p>

        <?php if (count($messages) === 0): ?>
            <p>Aucun message pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Sujet</th>
                        <th>Message</th>
                        <th>IP Client</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td data-label="ID"><?= $msg['id'] ?></td>
                        <td data-label="Nom"><?= htmlspecialchars($msg['nom']) ?></td>
                        <td data-label="Email">
                            <?= htmlspecialchars($msg['email']) ?>
                            <br>
                            <a class="btn-repondre" href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= urlencode($msg['sujet']) ?>&body=Bonjour <?= urlencode($msg['nom']) ?>,">
                                Répondre
                            </a>
                        </td>
                        <td data-label="Sujet"><?= htmlspecialchars($msg['sujet']) ?></td>
                        <td data-label="Message"><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                        <td data-label="IP Client"><?= $msg['ip_client'] ?></td>
                        <td data-label="Date"><?= $msg['created_at'] ?></td>
                        <td data-label="Actions">
                            <form method="POST" action="delete_message.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                <button type="submit" class="delete" onclick="return confirm('Supprimer ce message ?')">Supprimer</button>
                            </form>
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
