<?php
session_start();
require_once "../backend/config/database.php";

/* ======================
   CONNEXION DATABASE
====================== */
$db = new Database();
$conn = $db->getConnection();

/* ======================
   PRODUITS
====================== */

/* Les plus récents */
$sqlRecent = "
    SELECT * FROM produits
    ORDER BY created_at DESC
    LIMIT 8
";
$recent = $conn->query($sqlRecent)->fetchAll(PDO::FETCH_ASSOC);

/* Meilleur prix */
$sqlBestPrice = "
    SELECT * FROM produits
    ORDER BY prix ASC
    LIMIT 8
";
$bestPrice = $conn->query($sqlBestPrice)->fetchAll(PDO::FETCH_ASSOC);

/* ======================
   PANIER
====================== */
$nbArticles = 0;
if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $item) {
        $nbArticles += $item['quantite'];
    }
}

/* ======================
   FONCTIONS
====================== */
function getMainImage($p) {
    return !empty($p['image_principale'])
        ? 'images/' . $p['image_principale']
        : 'images/default.jpg';
}

function renderCarousel($title, $products) {
?>
<section class="featured-products">
    <h2><?= htmlspecialchars($title) ?></h2>

    <div class="carousel-wrapper">
        <div class="product-carousel">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <a href="produit.php?id=<?= $p['id'] ?>">
                        <img src="<?= getMainImage($p) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                    </a>
                    <p><?= htmlspecialchars($p['nom']) ?></p>

                    <?php if (!empty($p['ancien_prix'])): ?>
                        <span class="old-price">
                            <?= number_format($p['ancien_prix'], 2, ',', ' ') ?> CDF
                        </span>
                    <?php endif; ?>

                    <span class="new-price">
                        <?= number_format($p['prix'], 2, ',', ' ') ?> CDF
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="produits.php">
        <button class="shop-btn">SHOPPER</button>
    </a>
</section>
<?php } ?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stepora Shoes</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/header.css">
</head>

<body>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

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


<!-- HERO premier interface d'accueil-->
<section class="hero">
  <div class="hero-bg">
    <img id="heroShoe" src="images/r1-rouge.jpg" alt="Shoe">
  </div>

  <div class="hero-content">
    <h1>STEP INTO THE AURA OF STYLE</h1>
    <a href="produits.php"><button>BUY NOW</button></a>

    <div class="color-selector">
          <span
            class="color-dot active"
            data-color="white"
            style="background: #ffffff"
          ></span>
          <span
            class="color-dot"
            data-color="black"
            style="background: #111111"
          ></span>
          <span
            class="color-dot"
            data-color="blue"
            style="background: #3b82f6"
         ></span>
    </div>
  </div>
</section>

<!-- CAROUSELS -->
<?php renderCarousel("Les plus récents", $recent); ?>
<?php renderCarousel("Meilleur prix", $bestPrice); ?>

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

<!-- FOOTER (inchangé chez toi) -->
<footer class="footer">
      <!-- TOP CATEGORIES -->
      <div class="footer-top">
        <h3>TOP DES CATÉGORIES CHAUSSURES</h3>

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

<!-- JS -->
<script src="js/index.js" defer></script>

<script>
/* Défilement infini type Nike */
document.querySelectorAll('.product-carousel').forEach(carousel => {
    carousel.innerHTML += carousel.innerHTML;
});
</script>

</body>
</html>
