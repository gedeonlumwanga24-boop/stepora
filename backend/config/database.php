<?php
class Database {
    private $host = "localhost";
    private $db_name = "projet_boutique"; // Nom de ta base de données
    private $username = "root";           // Ton utilisateur MySQL
    private $password = "";               // Ton mot de passe MySQL
    public $conn;

    // Méthode pour récupérer la connexion
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            // Déclenche des exceptions en cas d’erreur
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur connexion BD : " . $e->getMessage());
        }

        return $this->conn;
    }
}