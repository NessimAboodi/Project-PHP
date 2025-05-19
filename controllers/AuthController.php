<?php
require_once("models/LoueurDAO.php");
session_start();

class AuthController {
    public function loginForm() {
        require("views/auth/login.php");
    }

    public function login() {
        $nom = $_POST['nom'] ?? '';
        $mdp = $_POST['mot_de_passe'] ?? '';

        $loueurDAO = new LoueurDAO();
        $loueur = $loueurDAO->verifierConnexion($nom, $mdp);

        if ($loueur) {
            $_SESSION['loueur'] = $loueur;
            header("Location: index.php?page=loueur&action=dashboard");
        } else {
            $erreur = "Nom ou mot de passe incorrect.";
            require("views/auth/login.php");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
