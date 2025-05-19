<?php
require_once("models/LoueurDAO.php");
session_start();

class LoueurController {
    public function dashboard() {
        if (!isset($_SESSION['loueur'])) {
            header("Location: index.php?page=auth&action=loginForm");
            exit();
        }

        $loueur = $_SESSION['loueur'];
        $loueurDAO = new LoueurDAO();
        $historique = $loueurDAO->getHistoriqueByNom($loueur->nom);
        $totaux = $loueurDAO->getTotalsGlobaux();

        require("views/loueur/dashboard.php");
    }
}
