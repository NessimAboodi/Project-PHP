<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Loueur</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h2>Connexion Loueur</h2>
    <?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form action="index.php?page=auth&action=login" method="post">
        <label>Nom :</label><br>
        <input type="text" name="nom" required><br><br>
        <label>Mot de passe :</label><br>
        <input type="password" name="mot_de_passe" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
 <hr>
<p><a href="index.php?page=admin&action=loginForm">→ Accès administrateur</a></p>

</body>
</html>
