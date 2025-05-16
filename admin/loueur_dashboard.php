<?php
session_start();
require_once 'connexion.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'loueur') {
    header("Location: login.php");
    exit;
}

$loueur_id = $_SESSION['id'];

$stmt = $pdo->prepare("SELECT * FROM loueur WHERE id = ?");
$stmt->execute([$loueur_id]);
$stats = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - <?= htmlspecialchars($_SESSION['nom']); ?></title>
</head>
<body>
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['nom']); ?></h1>

    <?php if ($stats): ?>
        <p>Retours KO : <?= $stats['nbAppelsKO']; ?></p>
        <p>Timeouts : <?= $stats['nbTimeouts']; ?></p>
    <?php else: ?>
        <p>Aucune statistique trouvée.</p>
    <?php endif; ?>

    <p><a href="logout.php">Déconnexion</a></p>
</body>
</html>
