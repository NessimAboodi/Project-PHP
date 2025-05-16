<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'connexion.php';

$message = '';
$editing = false;
$editLoueur = null;

// Traitement de la mise à jour d'un loueur
if (isset($_POST['update_id'])) {
    $updateId = (int) $_POST['update_id'];
    $newNom = trim($_POST['new_nom'] ?? '');
    $newKO = (int) ($_POST['new_ko'] ?? 0);
    $newTimeout = (int) ($_POST['new_timeout'] ?? 0);

    if (!empty($newNom)) {
        try {
            $stmt = $conn->prepare("UPDATE loueur SET nom = :nom, nbAppelsKO = :ko, nbTimeouts = :timeout WHERE id = :id");
            $stmt->execute([
                ':nom' => $newNom,
                ':ko' => $newKO,
                ':timeout' => $newTimeout,
                ':id' => $updateId
            ]);
            $message = " Loueur mis à jour avec succès.";
        } catch (PDOException $e) {
            $message = " Erreur lors de la mise à jour : " . $e->getMessage();
        }
    } else {
        $message = " Le nom ne peut pas être vide.";
    }
}

// Loueur à éditer
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM loueur WHERE id = :id");
    $stmt->execute([':id' => $editId]);
    $editLoueur = $stmt->fetch();
    if ($editLoueur) {
        $editing = true;
    }
}

// Ajouter un nouveau loueur
if (isset($_POST['add_nom'])) {
    $nom = trim($_POST['add_nom']);
    if (!empty($nom)) {
        try {
            $stmt = $conn->prepare("INSERT INTO loueur (nom, nbAppelsKO, nbTimeouts) VALUES (:nom, 0, 0)");
            $stmt->execute([':nom' => $nom]);
            $message = " Loueur ajouté avec succès.";
        } catch (PDOException $e) {
            $message = " Erreur lors de l'ajout : " . $e->getMessage();
        }
    } else {
        $message = " Veuillez entrer un nom.";
    }
}

// Récupération des loueurs
try {
    $stmt = $conn->query("SELECT * FROM loueur ORDER BY id DESC");
    $loueurs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des loueurs</title>
</head>
<body>
    <h1>Gestion des loueurs</h1>
    <p><a href="admin.php">⬅ Retour</a> | <a href="logout.php"> Déconnexion</a></p>

    <?php if (!empty($message)): ?>
        <p style="color: <?= str_starts_with($message, '') ? 'green' : 'red' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if ($editing && $editLoueur): ?>
        <h2> Modifier le loueur #<?= htmlspecialchars($editLoueur['id']) ?></h2>
        <form method="POST">
            <input type="hidden" name="update_id" value="<?= $editLoueur['id'] ?>">
            <label>Nom :</label>
            <input type="text" name="new_nom" value="<?= htmlspecialchars($editLoueur['nom']) ?>" required><br>
            <label>Appels KO :</label>
            <input type="number" name="new_ko" value="<?= $editLoueur['nbAppelsKO'] ?>" required><br>
            <label>Timeouts :</label>
            <input type="number" name="new_timeout" value="<?= $editLoueur['nbTimeouts'] ?>" required><br>
            <button type="submit"> Enregistrer</button>
            <a href="loueurs_admin.php">Annuler</a>
        </form>
    <?php else: ?>
        <h2> Ajouter un loueur</h2>
        <form method="POST">
            <label for="add_nom">Nom du loueur :</label>
            <input type="text" name="add_nom" id="add_nom" required>
            <button type="submit">Ajouter</button>
        </form>
    <?php endif; ?>

    <h2> Liste des loueurs</h2>
    <?php if (empty($loueurs)): ?>
        <p>Aucun loueur trouvé.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Appels KO</th>
                    <th>Timeouts</th>
					<th>Mot de passe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loueurs as $loueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($loueur['id']) ?></td>
                        <td><?= htmlspecialchars($loueur['nom']) ?></td>
                        <td><?= htmlspecialchars($loueur['nbAppelsKO']) ?></td>
                        <td><?= htmlspecialchars($loueur['nbTimeouts']) ?></td>
						<td><?= htmlspecialchars($loueur['mot_de_passe']) ?></td>
                        <td><a href="loueurs_admin.php?edit=<?= $loueur['id'] ?>"> Modifier</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
