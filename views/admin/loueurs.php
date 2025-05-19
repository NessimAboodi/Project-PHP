<link rel="stylesheet" href="public/css/style.css">

<h2>Gestion des loueurs</h2>

<h3>Ajouter un loueur</h3>
<form method="post" action="index.php?page=admin&action=ajouterLoueur">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
    <input type="number" name="nbAppelsKO" placeholder="KO" value="0">
    <input type="number" name="nbTimeouts" placeholder="Timeouts" value="0">
    <input type="date" name="date" required>
    <input type="submit" value="Ajouter">
</form>

<h3>Liste des loueurs</h3>
<table border="1">
    <tr>
        <th>ID</th><th>Nom</th><th>KO</th><th>Timeout</th><th>Date</th><th>Actions</th>
    </tr>
    <?php foreach ($listeLoueurs as $l): ?>
    <tr>
        <td><?= $l['id'] ?></td>
        <td><?= htmlspecialchars($l['nom']) ?></td>
        <td><?= $l['nbAppelsKO'] ?></td>
        <td><?= $l['nbTimeouts'] ?></td>
        <td><?= $l['date'] ?></td>
        <td>
            <a href="index.php?page=admin&action=modifierLoueurForm&id=<?= $l['id'] ?>">Modifier</a> |
            <a href="index.php?page=admin&action=supprimerLoueur&id=<?= $l['id'] ?>" onclick="return confirm('Supprimer ce loueur ?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="index.php?page=admin&action=dashboard">← Retour au dashboard</a>
