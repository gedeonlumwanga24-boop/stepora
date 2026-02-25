<?php
session_start();

/* ===============================
   PANIER
================================ */
$panier = $_SESSION['panier'] ?? [];
$total = 0;
$nbArticles = count($panier);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<!-- MOBILE OBLIGATOIRE -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mon panier</title>
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/panier.css">
<link rel="stylesheet" href="css/footer.css">
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
      <a href="apropos.php"><b>À-propos</b></a>
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
   CONTENU PANIER
================================ -->
<div class="container">

<h1>
  MON PANIER (<?= $nbArticles ?> produit<?= $nbArticles > 1 ? 's' : '' ?>)
</h1>
<p class="subtitle">
  Les articles dans votre panier ne sont pas réservés — commandez-les dès maintenant.
</p>

<?php if (!empty($panier)): ?>

<div class="panier-grid">

  <!-- PRODUITS -->
  <div class="panier-produits">

    <div class="alerte-stock">
      <strong>ÇA PART VITE</strong>
      <p>Commande avant qu'il ne soit trop tard !</p>
    </div>

    <?php foreach ($panier as $index => $item):
      $sousTotal = $item['prix'] * $item['quantite'];
      $total += $sousTotal;
    ?>

    <div class="produit-card animate">

      <div class="img-produit">
        <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nom']) ?>">
      </div>

      <div class="infos-produit">
        <h3><?= htmlspecialchars($item['nom']) ?></h3>
        <p><?= htmlspecialchars($item['couleur'] ?? '') ?> — Taille <?= htmlspecialchars($item['taille']) ?></p>
        <p class="stock-msg">Derniers articles disponibles</p>

        <div class="actions-produit">
          <select>
            <?php for ($i = 1; $i <= 10; $i++): ?>
              <option value="<?= $i ?>" <?= $i == $item['quantite'] ? 'selected' : '' ?>>
                <?= $i ?>
              </option>
            <?php endfor; ?>
          </select>

          <span class="prix"><?= number_format($sousTotal, 0, ',', ' ') ?> CDF</span>

          <a href="supprimer_panier.php?index=<?= $index ?>" class="supprimer">🗑️</a>
          <button class="like">❤</button>
        </div>
      </div>

    </div>

    <?php endforeach; ?>

  </div>

  <!-- SYNTHÈSE -->
  <div class="synthese-commande sticky">
    <h2>SYNTHESE</h2>
    <p><?= $nbArticles ?> article<?= $nbArticles > 1 ? 's' : '' ?></p>
    <p>Livraison : <strong>Gratuite</strong></p>
    <h3>Total : <?= number_format($total, 0, ',', ' ') ?> CDF</h3>

    <form action="commande.php" method="POST">
      <button class="commander-btn">Commander →</button>
    </form>
  </div>

</div>

<?php else: ?>

<div class="panier-vide">
  <p>Votre panier est vide.</p>
  <a href="produits.php">← Continuer mes achats</a>
</div>

<?php endif; ?>

</div>

<!-- ===============================
   JS
================================ -->
<script>
const produits = document.querySelectorAll('.produit-card.animate');
produits.forEach((p, i) => {
  p.style.opacity = 0;
  p.style.transform = 'translateY(20px)';
  setTimeout(() => {
    p.style.transition = '0.4s ease';
    p.style.opacity = 1;
    p.style.transform = 'translateY(0)';
  }, i * 120);
});
</script>

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


<!-- ============ JS ============ -->
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

</body>
</html>
