<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
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
        <h1>Bienvenue, <?= htmlspecialchars($_SESSION['admin']['nom']) ?> !</h1>
        <p>Utilisez le menu pour gérer vos messages et produits.</p>
    </main>

</div>

</body>
</html>


