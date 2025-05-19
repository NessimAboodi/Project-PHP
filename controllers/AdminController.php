<?php
require_once("models/AdminDAO.php");
require_once("models/LoueurDAO.php");
session_start();

class AdminController {
    public function loginForm() {
        require("views/admin/login.php");
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $mdp = $_POST['password'] ?? '';

        $dao = new AdminDAO();
        $admin = $dao->verifierConnexion($username, $mdp);

        if ($admin) {
            $_SESSION['admin'] = $admin;
            header("Location: index.php?page=admin&action=dashboard");
        } else {
            $erreur = "Login ou mot de passe incorrect.";
            require("views/admin/login.php");
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin&action=loginForm");
            exit();
        }

        $dao = new LoueurDAO();
        $totaux = $dao->getTotalsGlobaux();
        $listeLoueurs = $dao->getTousLesLoueurs();

        require("views/admin/dashboard.php");
    }

    public function loueurGestion() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin&action=loginForm");
            exit();
        }

        $dao = new LoueurDAO();
        $listeLoueurs = $dao->getTousLesLoueurs();
        require("views/admin/loueurs.php");
    }

    public function ajouterLoueur() {
        if (isset($_POST['nom'])) {
            $dao = new LoueurDAO();
            $dao->ajouterLoueur($_POST['nom'], $_POST['mot_de_passe'], $_POST['nbAppelsKO'], $_POST['nbTimeouts'], $_POST['date']);
            header("Location: index.php?page=admin&action=loueurGestion");
        }
    }

    public function supprimerLoueur() {
        if (isset($_GET['id'])) {
            $dao = new LoueurDAO();
            $dao->supprimerLoueur($_GET['id']);
            header("Location: index.php?page=admin&action=loueurGestion");
        }
    }

    public function modifierLoueurForm() {
        $dao = new LoueurDAO();
        $loueur = $dao->getLoueurById($_GET['id']);
        require("views/admin/modifier_loueur.php");
    }

    public function modifierLoueur() {
        if (isset($_POST['id'])) {
            $dao = new LoueurDAO();
            $dao->modifierLoueur($_POST['id'], $_POST['nom'], $_POST['mot_de_passe'], $_POST['nbAppelsKO'], $_POST['nbTimeouts'], $_POST['date']);
            header("Location: index.php?page=admin&action=loueurGestion");
        }
    }

    public function statistiques() {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin&action=loginForm");
            exit();
        }

        $dao = new LoueurDAO();
        $statsGlob = $dao->getStatsParJour();
        $listeLoueurs = $dao->getNomsLoueurs();
        $statsLoueur = null;
        if (isset($_POST['loueur'])) {
            $statsLoueur = $dao->getStatsParJourEtLoueur($_POST['loueur']);
        }

        require("views/admin/statistiques.php");
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=admin&action=loginForm");
    }
}
