<?php
session_start();
require_once __DIR__ . '/../backend/config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if (!isset($_GET['id'])) {
    header('Location: commandes.php');
    exit;
}

$id = (int) $_GET['id'];

/* ================= COMMANDE ================= */
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande introuvable");
}

/* ================= PRODUITS ================= */
$stmtProd = $pdo->prepare("SELECT * FROM commande_produits WHERE commande_id = ?");
$stmtProd->execute([$id]);
$produits = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

/* ================= COULEUR STATUT ================= */
$couleurStatut = match ($commande['statut']) {
    'validée' => '#3498db',
    'livrée'  => '#2ecc71',
    default   => '#f39c12', // en attente
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détail commande</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body { font-family: Arial, sans-serif; background:#f4f6f8; padding:20px }
a { text-decoration:none; color:#3498db; font-weight:bold }
.card { background:#fff; padding:20px; margin-bottom:20px; border-radius:6px }
table { width:100%; border-collapse:collapse }
th, td { padding:10px; border-bottom:1px solid #ddd; text-align:left }
th { background:#eee }
img { width:60px; border-radius:4px }
.statut { display:inline-block; padding:6px 12px; border-radius:20px; color:#fff; font-size:14px; font-weight:bold }
.btn-pdf { display:inline-block; padding:8px 12px; background:#e67e22; color:#fff; border-radius:6px; text-decoration:none; margin-top:10px }
</style>
</head>
<body>

<a href="commandes.php">⬅ Retour aux commandes</a>

<div class="card">
    <h2>🧾 Commande #<?= $commande['id'] ?></h2>
    <p><strong>Client :</strong> <?= htmlspecialchars($commande['prenom'].' '.$commande['nom']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($commande['email']) ?> 
    <a href="mailto:<?= htmlspecialchars($commande['email']) ?>?subject=Concernant votre commande #<?= $commande['id'] ?>" style="margin-left:10px; padding:5px 10px; background:#2ecc71; color:#fff; border-radius:4px; text-decoration:none; font-size:0.9rem;">
        📧 Contacter
    </a>
</p>

    <p><strong>Total :</strong> <?= number_format($commande['total'],2,',',' ') ?> €</p>
    <p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?></p> <!-- ajout date -->
    <p><strong>Statut :</strong>
        <span class="statut" style="background:<?= $couleurStatut ?>">
            <?= htmlspecialchars($commande['statut'] ?? 'en attente') ?>
        </span>
    </p>

    <!-- Bouton facture PDF -->
    <a class="btn-pdf" href="facture.php?id=<?= $commande['id'] ?>" target="_blank">
        🧾 Télécharger la facture PDF
    </a>
</div>

<div class="card">
    <h3>📦 Produits commandés</h3>
    <table>
        <tr>
            <th>Image</th>
            <th>Produit</th>
            <th>Taille</th>
            <th>Qté</th>
            <th>Prix</th>
        </tr>

        <?php foreach ($produits as $p): ?>
        <tr>
            <td>
                <?php
                $cheminFichier = __DIR__ . '/../public/images/' . $p['image'];
                $urlImage = '/PROJET-BOUTIQUE/public/images/' . $p['image'];

                if (file_exists($cheminFichier) && !empty($p['image'])) {
                    echo '<img src="'. htmlspecialchars($urlImage) .'" alt="">';
                } else {
                    echo '<span style="color:red;">Image introuvable</span>';
                }
                ?>
            </td>
            <td><?= htmlspecialchars($p['nom_produit']) ?></td>
            <td><?= htmlspecialchars($p['taille']) ?></td>
            <td><?= (int) $p['quantite'] ?></td>
            <td><?= number_format($p['prix'],2,',',' ') ?> €</td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
