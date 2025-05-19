<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un loueur</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <h2>Modifier un loueur</h2>

    <form method="post" action="index.php?page=admin&action=modifierLoueur">
        <input type="hidden" name="id" value="<?= $loueur['id'] ?>">

        <label>Nom :</label><br>
        <input type="text" name="nom" value="<?= htmlspecialchars($loueur['nom']) ?>" required><br><br>

        <label>Nouveau mot de passe :</label><br>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required><br><br>

        <label>Nombre d'appels KO :</label><br>
        <input type="number" name="nbAppelsKO" value="<?= $loueur['nbAppelsKO'] ?>"><br><br>

        <label>Nombre de timeouts :</label><br>
        <input type="number" name="nbTimeouts" value="<?= $loueur['nbTimeouts'] ?>"><br><br>

        <label>Date :</label><br>
        <input type="date" name="date" value="<?= $loueur['date'] ?>"><br><br>

        <input type="submit" value="Modifier">
    </form>

    <br>
    <a href="index.php?page=admin&action=loueurGestion">← Retour à la gestion des loueurs</a><br>
    <a href="index.php?page=auth&action=loginForm">← Connexion loueur</a>

</body>
</html>
