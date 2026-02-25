<?php 
session_start();
require_once "../backend/config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim(strtolower($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        $error = "Email introuvable";
    } else if (!password_verify($password, $admin['password'])) {
        $error = "Mot de passe incorrect";
    } else {
        // Met à jour la dernière connexion
        $conn->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?")->execute([$admin['id']]);

        // Stocke les infos admin dans la session
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'nom' => $admin['nom'],
            'email' => $admin['email']
        ];

        // Redirection
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Connexion</title>
<style>
body { font-family: Arial, sans-serif; background:#f4f4f4; display:flex; justify-content:center; align-items:center; height:100vh; }
form { background:#fff; padding:30px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:100%; max-width:400px; }
input { width:100%; padding:10px; margin:10px 0; box-sizing:border-box; }
button { padding:10px 20px; background:#2c3e50; color:#fff; border:none; cursor:pointer; border-radius:4px; width:100%; }
p.error { color:red; margin:0 0 10px 0; }
</style>
</head>
<body>

<form method="POST">
    <h2>Connexion Admin</h2>
    <?php if($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>

</body>
</html>
