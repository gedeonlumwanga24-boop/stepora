<?php
session_start();
require_once "../backend/config/database.php";

$db = new Database();
$conn = $db->getConnection();

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $error = "❌ Le mot de passe doit contenir au moins 6 caractères.";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare(
                "INSERT INTO clients (nom, email, mot_de_passe) VALUES (?, ?, ?)"
            );
            $stmt->execute([$nom, $email, $hashedPassword]);

            // 🔐 Connexion automatique
            $_SESSION['user'] = [
                'nom' => $nom,
                'email' => $email
            ];

            $success = "✅ Inscription réussie ! Redirection en cours…";

            // ⏳ Redirection après 2 secondes
            header("refresh:2;url=index.php");
        } catch (PDOException $e) {

            if ($e->getCode() == 23000) {
                $error = "❌ Cet email est déjà utilisé. Connecte-toi.";
            } else {
                $error = "❌ Une erreur est survenue. Réessaie plus tard.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un compte</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-container">

  <form method="POST" id="registerForm">
    <h1>Créer un compte</h1>
    <p class="subtitle">Rejoins-nous et commence l’aventure </p>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="field">
      <input type="text" name="nom" placeholder="Nom" required>
    </div>

    <div class="field">
      <input type="email" name="email" placeholder="Email" required>
    </div>

<div class="field password-field">
  <label for="password">
    Mot de passe
    <span class="toggle-password" id="togglePassword" aria-label="Afficher le mot de passe"></span>
  </label>
  <input type="password" name="password" id="password" required>
</div>


    <button type="submit">
      <span class="btn-text">S'inscrire</span>
      <span class="loader"></span>
    </button>

    <div class="footer">
      <span>Tu as déjà un compte ?</span>
      <a href="login.php">Se connecter</a>
    </div>
  </form>

</div>

<script>
/* 🔄 Loader */
const form = document.getElementById("registerForm");
form.addEventListener("submit", () => {
  form.classList.add("loading");
});

const toggle = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

toggle.addEventListener("click", () => {
  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";
  toggle.classList.toggle("active", isPassword);
});

</script>

</body>
</html>
