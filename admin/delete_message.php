<?php
session_start();
require_once "../backend/config/database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("DELETE FROM messages WHERE id=?");
    $stmt->execute([$_POST['id']]);
}

header("Location: messages.php");
exit;
?>
