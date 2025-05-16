
<?php
/**
 * Fonctions utilitaires pour l'application d'analyse de log
 * Mini-Projet PHP - Partie loueur et authentification
 */

/**
 * Vérifie si un utilisateur est authentifié
 * @return bool Vrai si l'utilisateur est connecté, faux sinon
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Vérifie si l'utilisateur connecté est un administrateur
 * @return bool Vrai si l'utilisateur est un administrateur, faux sinon
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Vérifie si l'utilisateur connecté est un loueur
 * @return bool Vrai si l'utilisateur est un loueur, faux sinon
 */
function isLoueur() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'loueur';
}

/**
 * Redirige l'utilisateur vers une page spécifiée
 * @param string $page Chemin de la page de destination
 * @return void
 */
function redirect($page) {
    header("Location: $page");
    exit;
}

/**
 * Sécurise une chaîne de caractères pour éviter les injections XSS
 * @param string $data Données à sécuriser
 * @return string Données sécurisées
 */
function secure($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Définit un message de succès dans la session
 * @param string $message Message à afficher
 * @return void
 */
function setSuccessMessage($message) {
    $_SESSION['success_message'] = $message;
}

/**
 * Définit un message d'erreur dans la session
 * @param string $message Message à afficher
 * @return void
 */
function setErrorMessage($message) {
    $_SESSION['error_message'] = $message;
}

/**
 * Génère un mot de passe aléatoire
 * @param int $length Longueur du mot de passe (par défaut 10)
 * @return string Mot de passe généré
 */
function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $password = '';
    $max = strlen($characters) - 1;
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, $max)];
    }
    
    return $password;
}

/**
 * Récupère les informations d'un loueur par son ID
 * @param PDO $pdo Instance de PDO
 * @param int $id ID du loueur
 * @return array|bool Tableau contenant les informations du loueur ou false si non trouvé
 */
function getLoueurById($pdo, $id) {
    $query = "SELECT * FROM loueurs WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les dernières statistiques d'un loueur
 * @param PDO $pdo Instance de PDO
 * @param int $loueurId ID du loueur
 * @return array|bool Tableau contenant les dernières statistiques ou false si non trouvé
 */
function getLatestStatsForLoueur($pdo, $loueurId) {
    $query = "SELECT * FROM logs_stats WHERE loueur_id = :loueur_id ORDER BY date_enregistrement DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':loueur_id', $loueurId, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère l'historique des statistiques d'un loueur
 * @param PDO $pdo Instance de PDO
 * @param int $loueurId ID du loueur
 * @param int $limit Nombre maximal d'enregistrements à récupérer
 * @param int $offset Décalage pour la pagination
 * @return array Tableau contenant l'historique des statistiques
 */
function getStatsHistoryForLoueur($pdo, $loueurId, $limit = 10, $offset = 0) {
    $query = "SELECT * FROM logs_stats WHERE loueur_id = :loueur_id 
              ORDER BY date_enregistrement DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':loueur_id', $loueurId, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère le nombre total d'enregistrements de statistiques pour un loueur
 * @param PDO $pdo Instance de PDO
 * @param int $loueurId ID du loueur
 * @return int Nombre total d'enregistrements
 */
function getTotalStatsCountForLoueur($pdo, $loueurId) {
    $query = "SELECT COUNT(*) as total FROM logs_stats WHERE loueur_id = :loueur_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':loueur_id', $loueurId, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['total'] ?? 0;
}

/**
 * Récupère les statistiques globales pour comparaison
 * @param PDO $pdo Instance de PDO
 * @param string $date Date des statistiques au format 'Y-m-d'
 * @return array Tableau contenant les statistiques globales
 */
function getGlobalStatsForDate($pdo, $date) {
    $query = "SELECT SUM(nb_appels_ko) as total_ko, SUM(nb_timeouts) as total_timeouts
              FROM logs_stats 
              WHERE DATE(date_enregistrement) = :date";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Formate une date MySQL pour l'affichage
 * @param string $dateTime Date au format MySQL
 * @param bool $includeTime Si vrai, inclut l'heure dans le résultat
 * @return string Date formatée
 */
function formatDate($dateTime, $includeTime = true) {
    $format = $includeTime ? 'd/m/Y à H:i' : 'd/m/Y';
    $date = new DateTime($dateTime);
    return $date->format($format);
}

/**
 * Calcule le pourcentage
 * @param int $value Valeur
 * @param int $total Total
 * @param int $decimals Nombre de décimales (par défaut 1)
 * @return string Pourcentage formaté
 */
function calculatePercentage($value, $total, $decimals = 1) {
    if ($total == 0) {
        return '0%';
    }
    
    $percentage = ($value / $total) * 100;
    return number_format($percentage, $decimals) . '%';
}
?>