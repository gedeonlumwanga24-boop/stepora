
<?php
session_start();
require_once "../backend/config/database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$error = "";
$success = "";

/* ================= AJOUT ADMIN ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nom && $email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Email invalide.";
        } else {
            $check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
            $check->execute([$email]);

            if ($check->fetch()) {
                $error = "Cet email existe déjà.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare(
                    "INSERT INTO admins (nom, email, password, created_at) VALUES (?, ?, ?, NOW())"
                );

                if ($stmt->execute([$nom, $email, $hash])) {
                    $success = "Administrateur ajouté avec succès.";
                } else {
                    $error = "Erreur lors de l'ajout.";
                }
            }
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}

/* ================= LISTE DES ADMINS ================= */
$stmt = $conn->prepare("SELECT id, nom, email, created_at, last_login, session_end FROM admins ORDER BY created_at DESC");
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ================= FONCTION TEMPS ================= */
function tempsPasse($start, $end) {
    if (!$start) return '-';
    if (!$end) $end = date('Y-m-d H:i:s'); // si encore connecté
    $diff = strtotime($end) - strtotime($start);
    $heures = floor($diff / 3600);
    $minutes = floor(($diff % 3600) / 60);
    return "{$heures}h {$minutes}m";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Ajouter un administrateur</title>
<link rel="stylesheet" href="css/aj-ad.css">
<style>
table { width:100%; border-collapse: collapse; background:#fff; margin-top:20px; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#2c3e50; color:#fff; }
tr:hover { background:#f2f2f2; }
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr { display:block; width:100%; }
    tr { margin-bottom:1rem; border:1px solid #ddd; padding:8px; }
    td { text-align:right; padding-left:50%; position:relative; }
    td::before { content: attr(data-label); position:absolute; left:10px; font-weight:bold; text-align:left; }
}
</style>
</head>
<body>

<div class="admin-container">

    <aside class="sidebar">
        <h2>STEPORA Admin</h2>
        <nav>
            <a href="dashboard.php">📊 Dashboard</a>
            <a href="clients.php">👤 Clients</a>
            <a href="messages.php">📬 Messages</a>
            <a href="produits.php">👟 Produits</a>
            <a href="commandes.php">📦 Commandes</a>
            <a href="stats.php">📊 Statistiques</a>
            <a href="ajouter_admin.php" class="active">➕ Ajouter admin</a>
            <a href="logout.php" class="logout">⏏ Déconnexion</a>
        </nav>
    </aside>

    <main class="content">
        <h1>➕ Ajouter un administrateur</h1>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" class="admin-form">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Ajouter l’administrateur</button>
        </form>

        <h2>🧑‍💼 Admins inscrits</h2>
        <?php if (count($admins) === 0): ?>
            <p>Aucun administrateur enregistré.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Inscrit le</th>
                        <th>Dernière connexion</th>
                        <th>Temps passé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $a): ?>
<tr>
    <td data-label="ID"><?= $a['id'] ?></td>
    <td data-label="Nom"><?= htmlspecialchars($a['nom']) ?></td>
    <td data-label="Email">
        <?= htmlspecialchars($a['email']) ?>
        <a href="mailto:<?= htmlspecialchars($a['email']) ?>?subject=Contact depuis Stepora"
           style="margin-left:10px; padding:5px 10px; background:#3498db; color:#fff; border-radius:4px; text-decoration:none; font-size:0.9rem;">
            📧 Contacter
        </a>
    </td>

    <td data-label="Inscrit le"><?= $a['created_at'] ?></td>
    <td data-label="Dernière connexion"><?= $a['last_login'] ?? 'Jamais' ?></td>
    <td data-label="Temps passé"><?= isset($a['last_login']) ? tempsPasse($a['last_login'], $a['session_end']) : '-' ?></td>
</tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
