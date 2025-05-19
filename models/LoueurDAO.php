<?php
require_once("models/Connexion.php");
require_once("models/Loueur.php");

class LoueurDAO {
    private $conn;

    public function __construct() {
        $this->conn = Connexion::getConnexion();
    }

    public function verifierConnexion($nom, $motDePasse) {
        $hash = hash('sha256', $motDePasse);
        $sql = "SELECT * FROM loueurs WHERE nom = ? AND mot_de_passe = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $hash]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Loueur($data['id'], $data['nom'], $data['nbAppelsKO'], $data['nbTimeouts'], $data['date']);
        }
        return null;
    }

    public function getHistoriqueByNom($nom) {
        $sql = "SELECT * FROM loueurs WHERE nom = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalsGlobaux() {
        $sql = "SELECT SUM(nbAppelsKO) AS totalKO, SUM(nbTimeouts) AS totalTimeouts FROM loueurs";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTousLesLoueurs() {
        $sql = "SELECT * FROM loueurs ORDER BY nom";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterLoueur($nom, $mot_de_passe, $nbAppelsKO = 0, $nbTimeouts = 0, $date = null) {
        $sql = "INSERT INTO loueurs (nom, mot_de_passe, nbAppelsKO, nbTimeouts, date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, hash('sha256', $mot_de_passe), $nbAppelsKO, $nbTimeouts, $date]);
    }

    public function modifierLoueur($id, $nom, $mot_de_passe, $nbAppelsKO, $nbTimeouts, $date) {
        $sql = "UPDATE loueurs SET nom = ?, mot_de_passe = ?, nbAppelsKO = ?, nbTimeouts = ?, date = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, hash('sha256', $mot_de_passe), $nbAppelsKO, $nbTimeouts, $date, $id]);
    }

    public function supprimerLoueur($id) {
        $sql = "DELETE FROM loueurs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    public function getLoueurById($id) {
        $sql = "SELECT * FROM loueurs WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getStatsParJour() {
        $sql = "SELECT date, SUM(nbAppelsKO) AS totalKO, SUM(nbTimeouts) AS totalTimeouts
                FROM loueurs GROUP BY date ORDER BY date DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatsParJourEtLoueur($nom) {
        $sql = "SELECT date, nbAppelsKO, nbTimeouts
                FROM loueurs WHERE nom = ? ORDER BY date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNomsLoueurs() {
        $sql = "SELECT DISTINCT nom FROM loueurs ORDER BY nom";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
