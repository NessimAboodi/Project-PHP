<?php
$host = 'localhost';
$db = 'log';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // pour afficher les erreurs PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // fetch en tableau associatif
    PDO::ATTR_EMULATE_PREPARES => false,                // utiliser les vrais prepared statements
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // En cas d'erreur, arrêter et afficher le message
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
