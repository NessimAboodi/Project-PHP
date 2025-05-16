<?php
/**
 * En-tête commun pour toutes les pages de l'application
 * Mini-Projet PHP - Application d'analyse de log
 * Partie loueur et authentification
 */

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = $loggedIn && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Redirection vers la page de connexion si l'utilisateur n'est pas connecté (sauf pour les pages d'authentification)
$currentPage = basename($_SERVER['PHP_SELF']);
$authPages = ['login.php', 'index.php']; // Pages accessibles sans authentification

if (!$loggedIn && !in_array($currentPage, $authPages) && strpos($currentPage, 'auth') === false) {
    header('Location: /auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse de Logs - <?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Accueil'; ?></title>
    
    <!-- Feuilles de style CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Inclusion conditionnelle de Chart.js pour les statistiques -->
    <?php if (isset($includeCharts) && $includeCharts): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                Analyse de Logs
            </div>
            
            <?php if ($loggedIn): ?>
            <nav>
                <ul>
                    <?php if ($isAdmin): ?>
                    <!-- Menu pour l'administrateur -->
                    <li><a href="/admin/dashboard.php">Tableau de bord</a></li>
                    <li><a href="/admin/loueurs.php">Gestion des loueurs</a></li>
                    <li><a href="/admin/statistics.php">Statistiques</a></li>
                    <?php else: ?>
                    <!-- Menu pour le loueur -->
                    <li><a href="/loueur/dashboard.php">Tableau de bord</a></li>
                    <li><a href="/loueur/profile.php">Mon profil</a></li>
                    <li><a href="/loueur/stats_current.php">Statistiques actuelles</a></li>
                    <li><a href="/loueur/stats_history.php">Historique</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="user-info">
                <span class="user-name">
                    <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Utilisateur'); ?>
                </span>
                <a href="/auth/logout.php" class="logout-btn">Déconnexion</a>
            </div>
            <?php endif; ?>
        </div>
    </header>
    
    <main class="container">
        <!-- Affichage des messages de session (succès, erreur, etc.) -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo htmlspecialchars($_SESSION['error_message']);
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Conteneur pour les messages d'erreur JavaScript -->
        <div id="error-container"></div>