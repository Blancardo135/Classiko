<?php
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/Team.php';

$teamsManager = new TeamsManager();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team = new Team($_POST['name'], $_POST['nbPlayers'], $_POST['descr'], $_POST['sport']);
    $errors = $team->validate();

    if (empty($errors)) {
        $teamsManager->addTeam($team);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une équipe</title>
</head>
<body>
    <h1>Ajouter une nouvelle équipe</h1>
    <a href="index.php">⬅️ Retour à la liste</a>

    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <label>Nom de l'équipe :
            <input type="text" name="name" required value="<?= $_POST['name'] ?? '' ?>">
        </label><br>

        <label>Nombre de joueurs :
            <input type="number" name="nbPlayers" required min="1" value="<?= $_POST['nbPlayers'] ?? '' ?>">
        </label><br>

        <label>Description :
            <textarea name="descr"><?= $_POST['descr'] ?? '' ?></textarea>
        </label><br>

        <label>Sport :
            <input type="text" name="sport" required value="<?= $_POST['sport'] ?? '' ?>">
        </label><br><br>

        <button type="submit">✅ Enregistrer</button>
    </form>
</body>
</html>