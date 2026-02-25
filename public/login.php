<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client && password_verify($password, $client['mot_de_passe'])) {

        $_SESSION['client'] = [
            'id'    => $client['id'],
            'nom'   => $client['nom'],
            'email' => $client['email']
        ];

        header("Location: index.php");
        exit;

    } else {
        $error = "❌ Email ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-container">

  <form method="POST" id="loginForm">
    <h1>Connexion</h1>
    <p class="subtitle">Content de te revoir</p>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="field">
      <input type="email" name="email" placeholder="Email" required>
    </div>

    <!-- 🔐 Mot de passe avec œil dans le label -->
    <div class="field password-field">
      <label for="password">
        Mot de passe
        <span class="toggle-password" id="togglePassword" aria-label="Afficher le mot de passe"></span>
      </label>
      <input type="password" name="password" id="password" required>
    </div>

    <button type="submit">
      <span class="btn-text">Se connecter</span>
      <span class="loader"></span>
    </button>

    <div class="footer">
      <span>Pas encore de compte ?</span>
      <a href="register.php">Créer un compte</a>
    </div>
  </form>

</div>

<script>
/* 🔄 Loader */
const form = document.getElementById("loginForm");
form.addEventListener("submit", () => {
  form.classList.add("loading");
});

/* 👁 Afficher / masquer mot de passe */
const toggle = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

toggle.addEventListener("click", () => {
  const isHidden = passwordInput.type === "password";
  passwordInput.type = isHidden ? "text" : "password";
  toggle.classList.toggle("active", isHidden);
});
</script>

</body>
</html>
