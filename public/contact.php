<?php
session_start();
require_once "../backend/config/database.php";

/* ===============================
   DB
================================ */
$db = new Database();
$conn = $db->getConnection();

/* ===============================
   PANIER (pour l’entête)
================================ */
$panier = $_SESSION['panier'] ?? [];
$nbArticles = count($panier);

/* ===============================
   TRAITEMENT FORMULAIRE
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $sujet = trim($_POST['sujet']);
    $message = trim($_POST['message']);
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($nom && $email && $sujet && $message) {
        $stmt = $conn->prepare(
            "INSERT INTO messages (nom, email, sujet, message, ip_client)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nom, $email, $sujet, $message, $ip]);

        $success = "✅ Votre message a bien été envoyé. Nous vous répondrons rapidement.";
    } else {
        $error = "❌ Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact - Stepora</title>

<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/contact.css">
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
   CONTENU
================================ -->
<main class="contact-container">

<h1>📩 Contactez-nous</h1>
<p class="subtitle">
  Une question ? Un problème ? Notre équipe vous répond rapidement.
</p>

<?php if (!empty($success)): ?>
  <p class="success"><?= $success ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
  <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST" class="contact-form">

        <label>Nom complet</label>
        <input type="text" name="nom" required
                value="<?= htmlspecialchars($_SESSION['client']['nom'] ?? '') ?>">

        <label>Email</label>
        <input type="email" name="email" required
                value="<?= htmlspecialchars($_SESSION['client']['email'] ?? '') ?>">

        <label>Sujet</label>
        <select name="sujet" required>
            <option value="">-- Choisir un sujet --</option>
            <option value="Commande">Commande</option>
            <option value="Livraison">Livraison</option>
            <option value="Paiement">Paiement</option>
            <option value="Produit">Produit</option>
            <option value="Autre">Autre</option>
        </select>

        <label>Message</label>
        <textarea name="message" rows="6" required></textarea>

        <button type="submit">📨 Envoyer le message</button>
        </form>
</main>

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
