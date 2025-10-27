<?php
require_once __DIR__ . '/../src/PlayersManager.php';
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/Player.php';

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getAllTeams();

$id = $_GET['id'] ?? null;
$player = $playersManager->getPlayer($id);

if (!$player) {
    echo "Joueur introuvable.";
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $player = new Player(
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['country'],
        $_POST['club'],
        $_POST['position'],
        $_POST['team_id'],
        $id
    );

    $errors = $player->validate();
    if (empty($errors)) {
        $playersManager->updatePlayer($player);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier un joueur</title>
</head>
<body>
    <h1>Modifier le joueur</h1>
    <a href="index.php">Retour</a>

    <?php if (!empty($errors)) : ?>
        <ul style="color:red;">
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label>Prénom : <input type="text" name="firstname" value="<?= htmlspecialchars($player->getFirstname()) ?>" required></label><br>
        <label>Nom : <input type="text" name="lastname" value="<?= htmlspecialchars($player->getLastname()) ?>" required></label><br>
        <label>Pays : <input type="text" name="country" value="<?= htmlspecialchars($player->getCountry()) ?>"></label><br>
        <label>Club : <input type="text" name="club" value="<?= htmlspecialchars($player->getClub()) ?>"></label><br>
        <label>Position : <input type="text" name="position" value="<?= htmlspecialchars($player->getPosition()) ?>" required></label><br>
        <label>Équipe :
            <select name="team_id" required>
                <?php foreach ($teams as $team) : ?>
                    <option value="<?= $team->getId(); ?>" <?= $team->getId() == $player->getTeamId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($team->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button type="submit">💾 Enregistrer</button>
    </form>
</body>
</html>