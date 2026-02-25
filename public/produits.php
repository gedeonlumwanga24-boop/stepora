

<?php
session_start();
require_once __DIR__ . "/../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

/* ================== FILTRES ================== */
$prixMax   = isset($_GET['prixMax']) ? (int)$_GET['prixMax'] : 80000;
$categorie = $_GET['categorie'] ?? '';
$taille    = $_GET['taille'] ?? '';
$tri       = $_GET['tri'] ?? 'recent';

/* ================== REQUÊTE ================== */
$sql = "SELECT * FROM produits WHERE prix <= :prixMax";
$params = ['prixMax' => $prixMax];




if(!empty($categorie)){
    $sql .= " AND categorie = :categorie";
    $params['categorie'] = $categorie;
}

if(!empty($taille)){
    $sql .= " AND FIND_IN_SET(:taille, tailles)";
    $params['taille'] = $taille;
}

switch($tri){
    case 'price_asc': $sql .= " ORDER BY prix ASC"; break;
    case 'price_desc': $sql .= " ORDER BY prix DESC"; break;
    default: $sql .= " ORDER BY created_at DESC";
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ================== IMAGE ================== */
function getMainImage($p) {
  return !empty($p['image_principale'])
    ? "images/" . $p['image_principale']
    : "images/default.jpg";
}

/* ================== PANIER ================== */
$nbArticles = 0;
if (!empty($_SESSION['panier'])) {
  foreach ($_SESSION['panier'] as $item) {
    $nbArticles += $item['quantite'];
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produits – Stepora</title>

<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/produits.css">
<link rel="stylesheet" href="css/footer.css">
</head>
<body>

<header class="main-header">
  <div class="header-container">

    <!-- LOGO -->
    <div class="logo">
      <a href="index.php">STEPORA</a>
    </div>

    <!-- MENU DESKTOP -->
    <nav class="nav-menu desktop-menu">
      <a href="index.php"><b>Accueil</b></a>
      <a href="produits.php"><b>Produits</b></a>
      <a href="apropos.php"><b>À-propos</b></a>
      <a href="contact.php"><b>Contact</b></a>
    </nav>

    <!-- ACTIONS -->
    <div class="header-actions">

      <!-- PROFIL -->
      <a href="login.php" class="icon-btn profile-btn">
        👤
      </a>

      <!-- PANIER -->
      <a href="panier.php" class="icon-btn cart-btn">
        🛒
        <span class="cart-count"><?= $nbArticles ?></span>
      </a>

      <!-- MENU MOBILE -->
        <!-- BOUTON HAMBURGER -->
      <button class="menu-toggle" id="menuToggle" aria-label="Menu">
        ☰
      </button>
    

<!-- MENU MOBILE -->
<nav class="mobile-menu" id="mobileMenu">
  <button class="close-menu" id="closeMenu">✕</button>
  <a href="index.php">Accueil</a>
  <a href="produits.php">Produits</a>
  <a href="apropos.php">À-propos</a>
  <a href="contact.php">Contact</a>
</nav>
</div>
</div>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

</header>


<main>
<!-- TOOLBAR -->
<div class="shop-toolbar">
  <button id="toggleFilters">⚙️ Filtres</button>

  <select id="sortSelect" onchange="applyFilters()">
    <option value="recent" <?= $tri=='recent'?'selected':'' ?>>Plus récents</option>
    <option value="price_asc" <?= $tri=='price_asc'?'selected':'' ?>>Prix croissant</option>
    <option value="price_desc" <?= $tri=='price_desc'?'selected':'' ?>>Prix décroissant</option>
  </select>
</div>

<!-- FILTRES -->
<div class="filters-panel" id="filtersPanel">

  <div class="filter-group1">
    <label>Prix max</label>
    <input type="range" id="priceRange" min="20000" max="80000" value="<?= $prixMax ?>" onchange="updatePrice()">
    <span id="priceValue"><?= $prixMax ?> FC</span>
  </div>

  <div class="filter-group">
    <label>Catégorie</label>
    <select id="brandFilter" onchange="applyFilters()">
      <option value="">Toutes</option>
      <option value="Sneakers" <?= $categorie=='Sneakers'?'selected':'' ?>>Sneakers</option>
      <option value="baskets" <?= $categorie=='baskets'?'selected':'' ?>>Baskets</option>
      <option value="Sneakers-Lifestyle" <?= $categorie=='Sneakers-Lifestyle'?'selected':'' ?>>Sneakers-Lifestyle</option>
      <option value="Baskets urbaines" <?= $categorie=='Baskets urbaines'?'selected':'' ?>>Baskets urbaines</option>
      <option value="Timberland" <?= $categorie=='Timberland'?'selected':'' ?>>Timberland</option>
    </select>
  </div>

  <div class="filter-group">
    <label>Pointure</label>
    <select id="sizeFilter" onchange="applyFilters()">
      <option value="">Toutes</option>
      <?php for($s=38;$s<=44;$s++): ?>
        <option value="<?= $s ?>" <?= $taille==$s?'selected':'' ?>><?= $s ?></option>
      <?php endfor; ?>
    </select>
  </div>

</div>

<!-- PRODUITS -->
<div class="produits-grid" id="produitsGrid">
<?php if(empty($produits)): ?>
  <p>Aucun produit trouvé.</p>
<?php else: ?>
  <?php foreach ($produits as $p): ?>
    <div class="product-card"
         data-price="<?= $p['prix'] ?>"
         data-category="<?= htmlspecialchars($p['categorie']) ?>">

      <a href="produit.php?id=<?= $p['id'] ?>">
        <img src="<?= getMainImage($p) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
      </a>

      <div class="product-info">
        <h3><?= htmlspecialchars($p['nom']) ?></h3>

        <p class="product-desc">
          <?= htmlspecialchars(mb_strimwidth($p['description'], 0, 60, "…")) ?>
        </p>

        <div class="product-footer">
          <span class="price"><?= number_format($p['prix'], 0, ' ', ' ') ?> FC</span>
          <span class="badge"><?= htmlspecialchars($p['categorie']) ?></span>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
</div>
</main>


<!-- LOGOS -->
<section class="brand-logos">
  <h2>Shopper par marque</h2>
  <div class="logos">
    <img src="images/logo-adidas.jpg">
    <img src="images/logo-asics.jpg">
    <img src="images/logo-nike.jpg">
    <img src="images/logo-timberland.jpg">
    <img src="images/logo-puma.jpg">
    <img src="images/logo-NBalance.jpg">
  </div>
</section>

<div class="footer-categories">
          <ul>
            <li>Baskets pour homme</li>
            <li>Baskets pour femme</li>
            <li>Baskets streetwear</li>
            <li>Chaussures de sport</li>
            <li>Chaussures running</li>
            <li>Chaussures lifestyle</li>
            <li>Baskets montantes</li>
            <li>Baskets basses</li>
            <li>Sandales & claquettes</li>
            <li>Chaussures casual</li>
          </ul>

          <ul>
            <li>Nike</li>
            <li>Adidas</li>
            <li>Puma</li>
            <li>New Balance</li>
            <li>Jordan</li>
            <li>Reebok</li>
            <li>Vans</li>
            <li>Converse</li>
            <li>Under Armour</li>
            <li>Asics</li>
          </ul>

          <ul>
            <li>Baskets blanches</li>
            <li>Baskets noires</li>
            <li>Baskets colorées</li>
            <li>Baskets en cuir</li>
            <li>Baskets respirantes</li>
            <li>Baskets sport indoor</li>
            <li>Baskets outdoor</li>
            <li>Chaussures training</li>
            <li>Chaussures basketball</li>
            <li>Chaussures football</li>
          </ul>

          <ul>
            <li>Accessoires chaussures</li>
            <li>Lacets</li>
            <li>Produits d’entretien</li>
            <li>Sacs de sport</li>
            <li>Chaussettes sport</li>
            <li>Nouveautés</li>
            <li>Meilleures ventes</li>
            <li>Promotions</li>
            <li>Cartes cadeaux</li>
          </ul>
        </div>

        <p class="footer-description">
          Découvre les meilleures baskets et chaussures tendance sur
          <strong>Stepora Shoes</strong>. Du streetwear au sport, nous
          sélectionnons des modèles stylés, confortables et durables pour
          t’accompagner au quotidien. Que tu sois fan de sneakers iconiques ou
          de chaussures performantes, trouve la paire parfaite et fais passer
          ton style au niveau supérieur.
        </p>
      </div>

      <div class="footer-socials">
        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/ged8806/" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" aria-label="Snapchat"
          ><i class="fab fa-snapchat-ghost"></i
        ></a>

        <a href="https://x.com/GedeonLumw77743" aria-label="X"><i class="fab fa-x-twitter"></i></a>
        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="https://wa.me/243970297987" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <a href="https://t.me/gedeonlumwanga" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
      </div>

      <!-- BOTTOM -->
      <div class="footer-bottom">
        <div class="footer-column">
          <h4>AIDE & INFORMATIONS</h4>
          <ul>
            <li>Assistance client</li>
            <li>Suivi de commande</li>
            <li>Livraison & retours</li>
            <li>Modes de paiement</li>
            <li>FAQ</li>
            <li>Plan du site</li>
          </ul>
        </div>

        <div class="footer-column">
          <h4>À PROPOS DE STEPORA</h4>
          <ul>
            <li>Qui sommes-nous ?</li>
            <li>Nos valeurs</li>
            <li>Nos partenaires</li>
            <li>Carrières</li>
            <li>Responsabilité & éthique</li>
          </ul>
        </div>

        <div class="footer-column">
          <h4>ENCORE PLUS</h4>
          <ul>
            <li>Application mobile</li>
            <li>Cartes cadeaux</li>
            <li>Offres spéciales</li>
            <li>Soldes</li>
            <li>Black Friday</li>
          </ul>
        </div>

        <div class="footer-column">
          <h4>SÉLECTIONNEZ LE PAYS</h4>
          <p>Vous êtes en 🇨🇩 RDC</p>
          <a href="#" class="change-country">CHANGER</a>
        </div>
      </div>

      <div class="footer-copy">© 2026 Stepora Shoes — Tous droits réservés</div>
    </footer>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>


<script>

const menuToggle = document.getElementById("menuToggle");
const mobileMenu = document.getElementById("mobileMenu");
const closeMenu = document.getElementById("closeMenu");
const overlay = document.getElementById("overlay");

// Ouvrir le menu
menuToggle.addEventListener("click", () => {
  mobileMenu.classList.add("open");
  overlay.classList.add("show");
});

// Fermer menu
closeMenu.addEventListener("click", () => {
  mobileMenu.classList.remove("open");
  overlay.classList.remove("show");
});

// Fermer en cliquant sur l'overlay
overlay.addEventListener("click", () => {
  mobileMenu.classList.remove("open");
  overlay.classList.remove("show");
});

// Optionnel : clic n'importe où en dehors du menu
document.addEventListener("click", (e) => {
  if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
    mobileMenu.classList.remove("open");
    overlay.classList.remove("show");
  }
});
</script>

<script>
function updatePrice(){
  document.getElementById('priceValue').innerText = document.getElementById('priceRange').value + ' FC';
  applyFilters();
}

function applyFilters(){
  const price = document.getElementById('priceRange').value;
  const cat = document.getElementById('brandFilter').value;
  const size = document.getElementById('sizeFilter').value;
  const sort = document.getElementById('sortSelect').value;

  // Redirige vers la même page avec les GET params
  let url = 'produits.php?prixMax=' + price + '&categorie=' + cat + '&taille=' + size + '&tri=' + sort;
  window.location.href = url;
}
</script>

</body>
</html>
