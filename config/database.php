<?php
/**
 * Configuration de la connexion à la base de données
 * Mini-Projet PHP - Application d'analyse de log
 * Partie loueur et authentification
 */

class Database {
    // Paramètres de connexion à la base de données
    private $host = "localhost";     // Serveur MySQL
    private $db_name = "log_analysis"; // Nom de la base de données (même que dans le code Java)
    private $username = "root";      // Nom d'utilisateur MySQL
    private $password = "";          // Mot de passe MySQL
    private $conn = null;            // Objet de connexion

    /**
     * Établit la connexion à la base de données
     * @return PDO|null Objet de connexion PDO ou null en cas d'erreur
     */
    public function getConnection() {
        try {
            // Création d'une nouvelle connexion PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Configuration pour afficher les erreurs SQL
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configuration pour récupérer les résultats sous forme de tableaux associatifs
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Définition du jeu de caractères
            $this->conn->exec("SET NAMES utf8");
            
            return $this->conn;
        } catch(PDOException $e) {
            // En cas d'erreur, afficher un message et renvoyer null
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            return null;
        }
    }
}
?>