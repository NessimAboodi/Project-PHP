<link rel="stylesheet" href="public/css/style.css">

<h2>Statistiques - Tous les loueurs</h2>

<table border="1">
    <tr>
        <th>Date</th>
        <th>Total KO</th>
        <th>Total Timeout</th>
    </tr>
    <?php foreach ($statsGlob as $ligne): ?>
        <tr>
            <td><?= $ligne['date'] ?></td>
            <td><?= $ligne['totalKO'] ?></td>
            <td><?= $ligne['totalTimeouts'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>

<h2>Statistiques par loueur</h2>
<form method="post" action="index.php?page=admin&action=statistiques">
    <label>Choisir un loueur :</label>
    <select name="loueur">
        <?php foreach ($listeLoueurs as $l): ?>
            <option value="<?= $l['nom'] ?>"><?= $l['nom'] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Afficher">
</form>

<?php if ($statsLoueur): ?>
    <h3>Statistiques pour <?= htmlspecialchars($_POST['loueur']) ?></h3>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>KO</th>
            <th>Timeout</th>
        </tr>
        <?php foreach ($statsLoueur as $ligne): ?>
            <tr>
                <td><?= $ligne['date'] ?></td>
                <td><?= $ligne['nbAppelsKO'] ?></td>
                <td><?= $ligne['nbTimeouts'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br>
<a href="index.php?page=admin&action=dashboard">← Retour au dashboard</a>
