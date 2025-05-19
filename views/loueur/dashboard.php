<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Loueur</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h2>Bienvenue <?= htmlspecialchars($loueur->nom) ?></h2>
    <p><strong>Date :</strong> <?= $loueur->date ?></p>
    <p><strong>KO :</strong> <?= $loueur->nbAppelsKO ?> / Total : <?= $totaux['totalKO'] ?></p>
    <p><strong>Timeout :</strong> <?= $loueur->nbTimeouts ?> / Total : <?= $totaux['totalTimeouts'] ?></p>
    <h3>Historique</h3>
    <table border="1">
        <tr><th>Date</th><th>KO</th><th>Timeout</th></tr>
        <?php foreach ($historique as $ligne): ?>
        <tr>
            <td><?= $ligne['date'] ?></td>
            <td><?= $ligne['nbAppelsKO'] ?></td>
            <td><?= $ligne['nbTimeouts'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="index.php?page=auth&action=logout">Déconnexion</a>
</body>
</html>
