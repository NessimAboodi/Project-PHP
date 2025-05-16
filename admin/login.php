<?php
session_start();

require 'connexion.php';  // inclure la connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire en sécurisant un peu
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Préparer la requête avec des placeholders nommés
        $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($sql);

        // Exécuter en passant un tableau associatif
        $stmt->execute([':username' => $username, ':password' => $password]);

        $user = $stmt->fetch();

        if ($user) {
            // Login OK, créer la session
            $_SESSION['role'] = 'admin';

            // Redirection vers la page admin
            header('Location: admin.php');
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    }
}
?>

<!-- Formulaire HTML de connexion -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
</head>
<body>
    <h1>Connexion Admin</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Nom d'utilisateur : <input type="text" name="username" required></label><br><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br><br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
