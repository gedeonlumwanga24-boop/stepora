<?php
session_start();

// Vider la session
$_SESSION = [];

// Détruire la session
session_destroy();

// Redirection après déconnexion
header("Location: index.php");
exit;
