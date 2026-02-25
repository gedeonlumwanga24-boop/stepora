<?php
session_start();

require_once __DIR__ . '/../backend/config/database.php';

/* ================= CONNEXION BD ================= */
$database = new Database();
$pdo = $database->getConnection();

if (!$pdo) {
    die("Erreur connexion base de données");
}

/* ================= PANIER ================= */
if (empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit;
}

$panier = $_SESSION['panier'];
$total = 0;

foreach ($panier as $item) {
    $total += $item['prix'] * $item['quantite'];
}

/* ================= CLIENT ================= */
$email = $_POST['email'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$adresse = $_POST['adresse'] ?? '';
$code_postal = $_POST['code_postal'] ?? '';
$ville = $_POST['ville'] ?? '';
$telephone = $_POST['telephone'] ?? '';

/* ================= INSERT COMMANDE ================= */
$stmt = $pdo->prepare("
    INSERT INTO commandes 
    (email, prenom, nom, adresse, code_postal, ville, telephone, total)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $email,
    $prenom,
    $nom,
    $adresse,
    $code_postal,
    $ville,
    $telephone,
    $total
]);

$commande_id = $pdo->lastInsertId();

/* ================= INSERT PRODUITS ================= */
$stmtProd = $pdo->prepare("
    INSERT INTO commande_produits 
    (commande_id, nom_produit, taille, quantite, prix, image)
    VALUES (?, ?, ?, ?, ?, ?)
");

foreach ($panier as $item) {
    $stmtProd->execute([
        $commande_id,
        $item['nom'],
        $item['taille'],
        $item['quantite'],
        $item['prix'],
        $item['image']
    ]);
}

/* ================= EMAIL ================= */
$subject = "Confirmation de votre commande #$commande_id";
$message = "
Bonjour $prenom,

Votre commande a bien été enregistrée.

Numéro de commande : $commande_id
Total : " . number_format($total, 2, ',', ' ') . " €

Merci pour votre confiance.
";

$headers = "From: boutique@site.com";
@mail($email, $subject, $message, $headers);

/* ================= VIDER PANIER ================= */
unset($_SESSION['panier']);

/* ================= REDIRECTION ================= */
header("Location: produits.php?commande=success");
exit;
