<?php
require_once __DIR__ . "/../../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

$prixMax   = $_GET['prixMax'] ?? 100000;
$categorie = $_GET['categorie'] ?? '';
$taille    = $_GET['taille'] ?? '';
$tri       = $_GET['tri'] ?? 'recent';

/* ================= BASE ================= */
$sql = "SELECT * FROM produits WHERE prix <= :prixMax";
$params = [
  'prixMax' => $prixMax
];

/* FILTRE CATEGORIE */
if (!empty($categorie)) {
  $sql .= " AND categorie = :categorie";
  $params['categorie'] = $categorie;
}

/* FILTRE TAILLE (CSV) */
if (!empty($taille)) {
  $sql .= " AND FIND_IN_SET(:taille, tailles)";
  $params['taille'] = $taille;
}

/* TRI */
switch ($tri) {
  case 'price_asc':
    $sql .= " ORDER BY prix ASC";
    break;
  case 'price_desc':
    $sql .= " ORDER BY prix DESC";
    break;
  default:
    $sql .= " ORDER BY created_at DESC";
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

function img($p) {
  return !empty($p['image_principale'])
    ? "images/" . $p['image_principale']
    : "images/default.jpg";
}

foreach ($produits as $p): ?>
  <div class="product-card">
    <a href="produit.php?id=<?= $p['id'] ?>">
      <img src="<?= img($p) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
    </a>
    <h3><?= htmlspecialchars($p['nom']) ?></h3>
    <p><?= substr($p['description'], 0, 60) ?>…</p>
    <span class="price"><?= number_format($p['prix'], 0, ' ', ' ') ?> FC</span>
  </div>
<?php endforeach; ?>
