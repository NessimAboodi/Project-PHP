<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h2>Bienvenue Admin</h2>
    <p>Total KO : <?= $totaux['totalKO'] ?></p>
    <p>Total Timeout : <?= $totaux['totalTimeouts'] ?></p>
    <a href="index.php?page=admin&action=loueurGestion">Gérer les loueurs</a><br>
    <a href="index.php?page=admin&action=statistiques">Voir les statistiques</a><br>
    <a href="index.php?page=admin&action=logout">Déconnexion</a>
</body>
</html>
