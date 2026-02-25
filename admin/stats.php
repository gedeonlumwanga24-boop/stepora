<?php
session_start();
require_once __DIR__ . '/../backend/config/database.php';

$database = new Database();
$pdo = $database->getConnection();

/* ================= STATS ================= */
$totalCommandes = $pdo->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
$enAttente = $pdo->query("SELECT COUNT(*) FROM commandes WHERE statut='en attente'")->fetchColumn();
$validees  = $pdo->query("SELECT COUNT(*) FROM commandes WHERE statut='validée'")->fetchColumn();
$livrees   = $pdo->query("SELECT COUNT(*) FROM commandes WHERE statut='livrée'")->fetchColumn();

$totalProduits = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();

$ca = $pdo->query("
    SELECT SUM(total) FROM commandes 
    WHERE statut IN ('validée','livrée')
")->fetchColumn() ?: 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background:#f4f6f8;
    padding:20px;
}
h1 { margin-bottom:20px }

.cards {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap:20px;
}
.card {
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}
.card h3 {
    margin:0;
    font-size:16px;
    color:#555;
}
.card .value {
    font-size:28px;
    font-weight:bold;
    margin-top:10px;
}

.green { color:#2ecc71 }
.blue { color:#3498db }
.orange { color:#f39c12 }
.red { color:#e74c3c }

.graphs {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(320px,1fr));
    gap:30px;
    margin-top:40px;
}
.graph-box {
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}
.graph-box h3 {
    text-align:center;
    margin-bottom:15px;
}

a.btn {
    display:inline-block;
    margin-top:20px;
    background:#2c3e50;
    color:#fff;
    padding:8px 14px;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>
<body>

<h1>📊 Dashboard Admin</h1>

<div class="cards">
    <div class="card">
        <h3>📦 Commandes</h3>
        <div class="value"><?= $totalCommandes ?></div>
    </div>

    <div class="card">
        <h3>🛍️ Produits</h3>
        <div class="value blue"><?= $totalProduits ?></div>
    </div>

    <div class="card">
        <h3>📩 Messages</h3>
        <div class="value red"><?= $totalMessages ?></div>
    </div>

    <div class="card">
        <h3>💰 Chiffre d'affaires</h3>
        <div class="value green"><?= number_format($ca,2,',',' ') ?> €</div>
    </div>
</div>

<div class="graphs">

    <!-- GRAPH STATUT -->
    <div class="graph-box">
        <h3>📦 Commandes par statut</h3>
        <canvas id="statutChart" height="200"></canvas>
    </div>

    <!-- GRAPH GLOBAL -->
    <div class="graph-box">
        <h3>📈 Vue globale</h3>
        <canvas id="globalChart" height="200"></canvas>
    </div>

    </div>
            <a class="btn" href="commandes.php">📦 Gérer commandes</a>
            <a class="btn" href="dashboard.php">📊 Dashboard</a>
            <a href="clients.php" class="active">👤 Clients</a>
            <a class="btn" href="messages.php">📬 Messages</a>
            <a class="btn" href="produits.php">👟 Produits</a>
            <a class="btn" href="stats.php">📊  Statistiques</a>
            <a class="btn" href="ajouter_admin.php" class="active">➕ Ajouter admin</a>
            <a class="btn" href="logout.php" class="logout">⏏ Déconnexion</a>
    <script>
        
// Graphique commandes par statut
new Chart(document.getElementById('statutChart'), {
    type: 'doughnut',
    data: {
        labels: ['En attente', 'Validées', 'Livrées'],
        datasets: [{
            data: [<?= $enAttente ?>, <?= $validees ?>, <?= $livrees ?>],
            backgroundColor: ['#f39c12', '#3498db', '#2ecc71']
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom' } }
    }
});

// Graphique global
new Chart(document.getElementById('globalChart'), {
    type: 'bar',
    data: {
        labels: ['Commandes', 'Produits', 'Messages'],
        datasets: [{
            data: [<?= $totalCommandes ?>, <?= $totalProduits ?>, <?= $totalMessages ?>],
            backgroundColor: ['#2c3e50', '#3498db', '#e74c3c']
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
