<?php
session_start();

$panier = $_SESSION['panier'] ?? [];
$total = 0;

if (empty($panier)) {
    header('Location: panier.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer la commande</title>
    <link rel="stylesheet" href="css/commande.css">
</head>
<body>

<div class="checkout-container">

    <!-- ================= FORMULAIRE ================= -->
    <div class="checkout-form">
        <h1>PASSER LA COMMANDE</h1>

        <form id="commandeForm" action="valider_commande.php" method="POST" novalidate>

            <h2>CONTACT</h2>
            <input type="email" name="email" placeholder="E-mail *" required>

            <h2>ADRESSE</h2>

            <div class="row">
                <input type="text" name="prenom" placeholder="Prénom *" required>
                <input type="text" name="nom" placeholder="Nom *" required>
            </div>

            <input type="text" name="adresse" placeholder="Adresse *" required>

            <div class="row">
                <input type="text" name="code_postal" placeholder="Code postal *" required>
                <input type="text" name="ville" placeholder="Ville *" required>
            </div>

            <input type="text" name="telephone" placeholder="Téléphone *" required>

            <button type="submit" class="btn-commande">
                PASSER LA COMMANDE →
            </button>

        </form>
    </div>

    <!-- ================= RÉCAP COMMANDE ================= -->
    <div class="checkout-recap">
        <h2>VOTRE COMMANDE</h2>

        <?php foreach ($panier as $item):
            $sousTotal = $item['prix'] * $item['quantite'];
            $total += $sousTotal;
        ?>
        <div class="recap-produit">
            <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="">
            <div>
                <strong><?= htmlspecialchars($item['nom']) ?></strong>
                <p>Taille : <?= htmlspecialchars($item['taille']) ?></p>
                <p>Qté : <?= (int)$item['quantite'] ?></p>
                <p><?= number_format($sousTotal, 2, ',', ' ') ?> €</p>
            </div>
        </div>
        <?php endforeach; ?>

        <hr>

        <p>Livraison : <strong>Gratuit</strong></p>
        <h3>Total : <?= number_format($total, 2, ',', ' ') ?> €</h3>
    </div>

</div>

<!-- ================= TOAST ================= -->
<div id="toast" class="toast">
    ✅ Commande passée avec succès
</div>

<!-- ================= JS ================= -->
<script>
const form = document.getElementById('commandeForm');
const toast = document.getElementById('toast');

form.addEventListener('submit', function (e) {
    e.preventDefault();

    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    toast.classList.add('show');

    setTimeout(() => {
        form.submit();
    }, 1500);
});
</script>

</body>
</html>
