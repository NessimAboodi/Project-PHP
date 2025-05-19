<?php
require_once("models/Connexion.php");

class AdminDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connexion::getConnexion();
    }

    public function verifierConnexion($username, $motDePasse) {
        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $motDePasse]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
