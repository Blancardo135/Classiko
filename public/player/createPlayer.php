<?php
require_once __DIR__ . '/../src/PlayersManager.php';
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/Player.php';

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getAllTeams();

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $country = $_POST['country'] ?? '';
    $club = $_POST['club'] ?? '';
    $position = $_POST['position'];
    $team_id = $_POST['team_id'];

    $player = new Player($firstname, $lastname, $country, $club, $position, $team_id);
    $errors = $player->validate();

    if (empty($errors)) {
        $playersManager->addPlayer($player);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Créer un joueur</title>
</head>
<body>
    <h1>Créer un joueur</h1>
    <a href="index.php">Retour</a>

    <?php if (!empty($errors)) : ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label>Prénom : <input type="text" name="firstname" required></label><br>
        <label>Nom : <input type="text" name="lastname" required></label><br>
        <label>Pays : <input type="text" name="country"></label><br>
        <label>Club : <input type="text" name="club"></label><br>
        <label>Position : <input type="text" name="position" required></label><br>
        <label>Équipe :
            <select name="team_id" required>
                <option value="">-- Sélectionner --</option>
                <?php foreach ($teams as $team) : ?>
                    <option value="<?= $team->getId(); ?>"><?= htmlspecialchars($team->getName()); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>