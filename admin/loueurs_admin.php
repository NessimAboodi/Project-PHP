<?php
session_start();
require_once 'connexion.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Ajouter un loueur
if (isset($_POST['add'])) {
    $nom = $_POST['nom'];
    $nbAppelsKO = $_POST['nbAppelsKO'] ?? 0;
    $nbTimeouts = $_POST['nbTimeouts'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO loueur (nom, nbAppelsKO, nbTimeouts) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $nbAppelsKO, $nbTimeouts]);

    header("Location: loueurs_admin.php");
    exit;
}

// Modifier un loueur
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $nbAppelsKO = $_POST['nbAppelsKO'] ?? 0;
    $nbTimeouts = $_POST['nbTimeouts'] ?? 0;

    $stmt = $conn->prepare("UPDATE loueur SET nom = ?, nbAppelsKO = ?, nbTimeouts = ? WHERE id = ?");
    $stmt->execute([$nom, $nbAppelsKO, $nbTimeouts, $id]);

    header("Location: loueurs_admin.php");
    exit;
}

// Supprimer un loueur
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM loueur WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: loueurs_admin.php");
    exit;
}

// Récupération des loueurs
$loueurs = $conn->query("SELECT * FROM loueur")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Loueurs</title>
</head>
<body>
    <h1>Gestion des Loueurs</h1>

    <h2>Ajouter un Loueur</h2>
    <form method="post">
        Nom : <input type="text" name="nom" required>
        Appels KO : <input type="number" name="nbAppelsKO" min="0" value="0" required>
        Timeouts : <input type="number" name="nbTimeouts" min="0" value="0" required>
        <button type="submit" name="add">Ajouter</button>
    </form>

    <h2>Liste des Loueurs</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Appels KO</th>
            <th>Timeouts</th>
            <th>Actions</th>
        </tr>
        <?php foreach($loueurs as $loueur): ?>
        <tr>
            <form method="post">
                <td><input type="text" name="id" value="<?= $loueur['id']; ?>" readonly></td>
                <td><input type="text" name="nom" value="<?= htmlspecialchars($loueur['nom']); ?>"></td>
                <td><input type="number" name="nbAppelsKO" min="0" value="<?= (int)$loueur['nbAppelsKO']; ?>"></td>
                <td><input type="number" name="nbTimeouts" min="0" value="<?= (int)$loueur['nbTimeouts']; ?>"></td>
                <td>
                    <button type="submit" name="edit">Modifier</button>
                    <a href="?delete=<?= $loueur['id']; ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="admin.php">Retour Dashboard</a></p>
</body>
</html>
