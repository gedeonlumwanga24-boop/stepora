<?php 
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ================= ACTIONS ================= */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("SELECT email, prenom, statut FROM commandes WHERE id = ?");
    $stmt->execute([$id]);
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$commande) die("Commande introuvable");

    $nouveauStatut = null;
    $messageMail = "";

    if ($_GET['action'] === 'valider' && $commande['statut'] === 'en attente') {
        $nouveauStatut = 'validée';
        $messageMail = "Bonjour {$commande['prenom']},\nVotre commande #$id a été VALIDÉE ✅.";
    }

    if ($_GET['action'] === 'livrer' && $commande['statut'] === 'validée') {
        $nouveauStatut = 'livrée';
        $messageMail = "Bonjour {$commande['prenom']},\nVotre commande #$id a été LIVRÉE 📦.";
    }

    if ($_GET['action'] === 'supprimer') {
        $conn->prepare("DELETE FROM commande_produits WHERE commande_id = ?")->execute([$id]);
        $conn->prepare("DELETE FROM commandes WHERE id = ?")->execute([$id]);
        header('Location: commandes.php');
        exit;
    }

    if ($nouveauStatut) {
        $conn->prepare("UPDATE commandes SET statut = ? WHERE id = ?")->execute([$nouveauStatut, $id]);
        @mail($commande['email'], "Commande #$id – Statut : $nouveauStatut", $messageMail, "From: boutique@site.com");
    }

    header('Location: commandes.php');
    exit;
}

/* ================= LISTE DES COMMANDES ================= */
$commandes = $conn->query("SELECT * FROM commandes ORDER BY date_commande DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Commandes</title>
<link rel="stylesheet" href="css/admin.css">
<style>
/* Pastilles de statut */
.statut {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    color: #fff;
    font-weight: bold;
    font-size: 0.9rem;
    min-width: 80px;
    text-align: center;
}
.statut-enattente { background: #f39c12; }
.statut-validee { background: #3498db; }
.statut-livree { background: #2ecc71; }

/* Boutons d'action */
.btn {
    padding: 6px 10px;
    font-size: 0.85rem;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    margin: 2px 0;
    display: inline-block;
}
.btn.view { background: #3498db; }
.btn.ok { background: #2ecc71; }
.btn.delete { background: #e74c3c; }

/* Actions en flex */
.actions-container { display: flex; flex-wrap: wrap; gap: 6px; }

/* Tableau */
table { width:100%; border-collapse: collapse; background:#fff; margin-top:15px; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; vertical-align: middle; }
th { background:#2c3e50; color:#fff; }

/* Responsive mobile */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr { display: block; width: 100%; }
    tr { margin-bottom: 1rem; border: 1px solid #ddd; padding: 8px; }
    td { text-align: right; padding-left: 50%; position: relative; }
    td::before { content: attr(data-label); position: absolute; left: 10px; font-weight: bold; text-align: left; }
    .actions-container { justify-content: flex-start; }
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
        <h1>📦 Commandes</h1>
        <p>Voici toutes les commandes passées par vos clients :</p>

        <?php if (count($commandes) === 0): ?>
            <p>Aucune commande pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Date</th> <!-- ajoutée -->
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $c): ?>
                    <tr>
                        <td data-label="ID">#<?= $c['id'] ?></td>
                        <td data-label="Client"><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?></td>
                        <td data-label="Total"><?= number_format($c['total'],2,',',' ') ?> CDF</td>
                        <td data-label="Date"><?= date('d/m/Y H:i', strtotime($c['date_commande'])) ?></td> <!-- affichage date -->
                        <td data-label="Statut">
                            <span class="statut <?= $c['statut']==='validée' ? 'statut-validee' : ($c['statut']==='livrée' ? 'statut-livree' : 'statut-enattente') ?>">
                                <?= htmlspecialchars($c['statut'] ?? 'en attente') ?>
                            </span>
                        </td>
                        <td data-label="Actions">
                            <div class="actions-container">
                                <a href="detail_commande.php?id=<?= $c['id'] ?>" class="btn view">Voir</a>
                                <?php if ($c['statut'] === 'en attente'): ?>
                                    <a href="?action=valider&id=<?= $c['id'] ?>" class="btn ok">Valider</a>
                                <?php endif; ?>
                                <?php if ($c['statut'] === 'validée'): ?>
                                    <a href="?action=livrer&id=<?= $c['id'] ?>" class="btn ok">Livrée</a>
                                <?php endif; ?>
                                <a href="?action=supprimer&id=<?= $c['id'] ?>" class="btn delete" onclick="return confirm('Supprimer cette commande ?')">Supprimer</a>
                            </div>
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
