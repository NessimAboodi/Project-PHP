<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <h2>Connexion Admin</h2>
    <?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
    <form method="post" action="index.php?page=admin&action=login">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>
        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Connexion">
    </form>
    <a href="index.php?page=auth&action=loginForm">← Retour à la connexion loueur</a><br>

</body>
</html>
