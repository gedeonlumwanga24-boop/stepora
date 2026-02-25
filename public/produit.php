<?php
session_start();

/* ================= PANIER ================= */
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* ✅ FIX NAVBAR */
$nbArticles = count($_SESSION['panier']);

require_once __DIR__ . '/../backend/models/Produit.php';
$produitModel = new Produit();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$produit = $produitModel->getProduitById($id);

if (!$produit) {
    echo "<p>Produit non trouvé</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taille = $_POST['taille'] ?? '';

    if (empty($taille)) {
        $erreur = "Veuillez sélectionner une taille";
    } else {
        $_SESSION['panier'][] = [
            'id'       => $produit['id'],
            'nom'      => $produit['nom'],
            'prix'     => $produit['prix'],
            'image'    => $produit['image_principale'],
            'taille'   => $taille,
            'quantite' => 1
        ];

        header("Location: panier.php");
        exit;
    }
}

function getMainImage($p)
{
    return 'images/' . ($p['image_principale'] ?? 'default.jpg');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produit['nom']) ?> - Stepora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/produit.css">
    <link rel="stylesheet" href="css/header.css">
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

<main class="produit-page">
    <div class="produit-container">

        <!-- ============ GALERIE ============ -->
        <div class="produit-gallery">

            <div class="thumbs">
                <?php foreach (explode(',', $produit['images']) as $img): ?>
                    <img class="thumb" src="images/<?= trim($img) ?>" alt="">
                <?php endforeach; ?>
            </div>

            <div class="main-image">
                <span class="badge-note">⭐ Bien noté</span>

                <button class="nav-img prev" tabindex="0">‹</button>
                <button class="nav-img next" tabindex="0">›</button>

                <img
                    id="currentImage"
                    src="<?= getMainImage($produit) ?>"
                    alt="<?= htmlspecialchars($produit['nom']) ?>"
                >
            </div>
        </div>

        <!-- ============ INFOS ============ -->
        <div class="produit-info">

            <h1><?= htmlspecialchars($produit['nom']) ?></h1>
            <p class="prix"><?= number_format($produit['prix'], 2, ',', ' ') ?> FC</p>
            <p class="description"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>

            <?php if (!empty($erreur)): ?>
                <p class="error"><?= $erreur ?></p>
            <?php endif; ?>

            <form method="POST">

                <div class="tailles">
                    <p>Choisir la taille</p>
                    <?php foreach (explode(',', $produit['tailles']) as $t): ?>
                        <label class="taille-btn">
                            <input type="radio" name="taille" value="<?= $t ?>" hidden>
                            <?= $t ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn-ajouter">Ajouter au panier</button>

                <!-- META -->
                <div class="produit-meta">

                    <div class="meta-actions">
                        <button type="button" class="like-btn">♡</button>
                        <span class="meta-like-text">Ajouter aux favoris</span>
                    </div>

                    <div class="meta-infos">
                        <p>✔ Livraison rapide partout au pays</p>
                        <p>✔ Retours gratuits sous 30 jours</p>
                        <p>✔ Produit authentique et certifié</p>
                        <p>✔ Qualité premium Stepora</p>
                        <p>✔ Paiement sécurisé</p>
                    </div>

                </div>
            </form>

        </div>
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
<script src="js/produit.js" defer></script>


</body>
</html>
