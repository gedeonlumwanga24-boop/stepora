<?php
session_start();

/* ===============================
   PANIER (pour l'entête)
================================ */
$panier = $_SESSION['panier'] ?? [];
$nbArticles = count($panier);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>À propos – Stepora</title>

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/apropos.css">
  <link rel="stylesheet" href="css/footer.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- ===============================
   HEADER
================================ -->
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
      <a href="apropos.php" class="active"><b>À-propos</b></a>
      <a href="contact.php"><b>Contact</b></a>
    </nav>

    <!-- ACTIONS -->
    <div class="header-actions">

      <!-- PROFIL -->
      <a href="login.php" class="icon-btn profile-btn">👤</a>

      <!-- PANIER -->
      <a href="panier.php" class="icon-btn cart-btn">
        🛒
        <?php if ($nbArticles > 0): ?>
          <span class="cart-count"><?= $nbArticles ?></span>
        <?php endif; ?>
      </a>

      <!-- MENU MOBILE -->
      <button class="menu-toggle" id="menuToggle">☰</button>

    </div>
  </div>

  <!-- MENU MOBILE -->
  <nav class="mobile-menu" id="mobileMenu">
    <button class="close-menu" id="closeMenu">✕</button>
    <a href="index.php">Accueil</a>
    <a href="produits.php">Produits</a>
    <a href="apropos.php">À-propos</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<!-- ===============================
   CONTENU
================================ -->
<main class="apropos">

  <!-- HERO -->
  <section class="apropos-hero" style="background-image: url('images/j4-noire.jpg');">
    <div class="hero-content">
      <h1>STEP INTO THE AURA</h1>
      <p>
        Stepora n’est pas qu’une boutique. C’est une vision, un mouvement, une culture.
        Chaque sneaker raconte une histoire, chaque pas affirme votre identité.
      </p>
      <a href="produits.php" class="cta-btn">Découvrir les produits</a>
    </div>
  </section>

  <!-- MISSION -->
  <section class="apropos-section">
    <div class="container">
      <h2>Notre mission</h2>
      <p>
        Transformer la façon dont vous vivez vos sneakers. Allier style, confort
        et performance pour que chaque pas soit une expérience unique.
      </p>
      <p>
        Chez Stepora, une sneaker est plus qu’un produit : c’est une extension
        de votre personnalité.
      </p>
    </div>
  </section>

  <!-- HISTOIRE -->
  <section class="apropos-section image-left">
    <div class="image" style="background-image: url('images/air-max2.jpg');"></div>
    <div class="text">
      <h2>Notre histoire</h2>
      <p>
        Fondée en 2020 par des passionnés, Stepora est née d’une idée simple :
        créer une communauté autour du style et du mouvement.
      </p>
      <p>
        Chaque paire reflète notre exigence de qualité et notre amour du détail.
      </p>
    </div>
  </section>

  <!-- VALEURS -->
  <section class="apropos-values image-right">
    <div class="image" style="background-image: url('images/ar-4.jpg');"></div>
    <div class="text">
      <h2>Nos valeurs</h2>
      <p>🔥 <strong>Style</strong> — design, identité, créativité</p>
      <p>⚡ <strong>Performance</strong> — confort et efficacité</p>
      <p>🌍 <strong>Vision</strong> — culture urbaine et expression</p>
      <p>🤝 <strong>Engagement</strong> — qualité et respect</p>
    </div>
  </section>

  <!-- ÉQUIPE -->
  <section class="apropos-section image-left">
    <div class="image" style="background-image: url('images/r1-rouge.jpg');"></div>
    <div class="text">
      <h2>Notre équipe</h2>
      <p>
        Designers, créateurs et passionnés de sneakers réunis autour d’une
        même ambition : inspirer.
      </p>
    </div>
  </section>

  <!-- ENGAGEMENTS -->
  <section class="apropos-section image-right">
    <div class="image" style="background-image: url('images/j-1-retro.jpg');"></div>
    <div class="text">
      <h2>Nos engagements</h2>
      <ul>
        <li>Produits durables et fiables</li>
        <li>Respect de l’environnement</li>
        <li>Expérience client premium</li>
        <li>Créativité et expression personnelle</li>
      </ul>
    </div>
  </section>

  <!-- CTA -->
  <section class="apropos-cta">
    <h2>Prêt à entrer dans l’aura ?</h2>
    <a href="produits.php" class="cta-btn">Découvrir les produits</a>
  </section>

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



<!-- ===============================
   JS MENU MOBILE
================================ -->
<script>
const menuToggle = document.getElementById("menuToggle");
const mobileMenu = document.getElementById("mobileMenu");
const closeMenu = document.getElementById("closeMenu");
const overlay = document.getElementById("overlay");

menuToggle.addEventListener("click", () => {
  mobileMenu.classList.add("open");
  overlay.classList.add("show");
});

closeMenu.addEventListener("click", closeAll);
overlay.addEventListener("click", closeAll);

function closeAll() {
  mobileMenu.classList.remove("open");
  overlay.classList.remove("show");
}
</script>

</body>
</html>
