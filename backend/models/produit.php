<?php
class Database {
    private $host = "localhost";
    private $db_name = "projet_boutique"; // Change selon le nom de ta base
    private $username = "root";          // Utilisateur XAMPP par défaut
    private $password = "";              // Mot de passe XAMPP par défaut
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}

class Produit {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Récupérer un produit par ID
    public function getProduitById($id) {
        $query = "SELECT * FROM produits WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produit ? $produit : null;
    }

    // Optionnel : récupérer tous les produits
    public function getAllProduits() {
        $query = "SELECT * FROM produits ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
