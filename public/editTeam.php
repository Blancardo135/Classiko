<?php
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/Team.php';

$teamsManager = new TeamsManager();
$teamId = (int) ($_GET['id'] ?? 0);
$team = $teamsManager->getTeam($teamId);

if (!$team) {
    echo "Équipe non trouvée.";
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team = new Team($_POST['name'], $_POST['nbPlayers'], $_POST['descr'], $_POST['sport'], $teamId);
    $errors = $team->validate();

    if (empty($errors)) {
        $teamsManager->updateTeam($teamId, $team);
        header("Location: viewTeam.php?id=$teamId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l’équipe</title>
</head>
<body>
    <h1>Modifier l’équipe</h1>
    <a href="index.php">⬅️ Retour à la liste</a>

    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form method="post">
        <label>Nom de l'équipe :
            <input type="text" name="name" required value="<?= htmlspecialchars($team->getName()) ?>">
        </label><br>

        <label>Nombre de joueurs :
            <input type="number" name="nbPlayers" required min="1" value="<?= $team->getNbPlayers() ?>">
        </label><br>

        <label>Description :
            <textarea name="descr"><?= htmlspecialchars($team->getDescr()) ?></textarea>
        </label><br>

        <label>Sport :
            <input type="text" name="sport" required value="<?= htmlspecialchars($team->getSport()) ?>">
        </label><br><br>

        <button type="submit">💾 Enregistrer les modifications</button>
    </form>
</body>
</html>