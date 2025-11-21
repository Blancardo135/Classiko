<?php

require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;
use Database;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireLogin();

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams($currentUserId);
$errors = [];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die(t('no_player_id'));
}


$playerId = (int) $_GET['id'];

// ownership check
$pdo = Database::getInstance()->getPdo();
$ownerStmt = $pdo->prepare('SELECT owner_user_id FROM players WHERE id = :id');
$ownerStmt->bindValue(':id', $playerId, \PDO::PARAM_INT);
$ownerStmt->execute();
$owner = $ownerStmt->fetchColumn();

if ($owner !== false && ((int)$owner !== (int)$currentUserId)) {
    header('Location: ../403.php');
    exit();
}

$player = $playersManager->getPlayerById($playerId);

if (!$player) {
    die(t('not_found'));
}

$firstname = $player->getFirstname();
$lastname = $player->getLastname();
$country = $player->getCountry();
$club = $player->getClub();
$position = $player->getPosition();
$team_id = $player->getTeamId();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $country = trim($_POST['country']);
    $club = trim($_POST['club']);
    $position = trim($_POST['position']);
    $team_id = $_POST['team_id'];

    try {
        $updatedPlayer = new Player(
            $playerId,
            $firstname,
            $lastname,
            $country,
            $club,
            $position,
            (int)$team_id
        );

        $updatedPlayer->setId($playerId);
        $playersManager->updatePlayer($updatedPlayer);
        header("Location: index.php");

        exit;
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    } catch (PDOException $e) {
        $errors[] = t('db_error') . $e->getMessage();
    } catch (Exception $e) {
        $errors[] = t('unexpected_error') . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title><?= t('edit_player') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('edit_player') ?></h1>
        <p><a href="../index.php"><?= t('home') ?></a> > <a href="index.php"><?= t('players_management') ?></a> > <?= t('edit_player') ?></p>

        <?php if (!empty($errors)): ?>
            <article style="color: red;">
                <p><?= t('form_error') ?></p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endif; ?>

        <form action="editPlayer.php?id=<?= $playerId ?>" method="POST">
            <label for="firstname"><?= t('player_firstName') ?> :</label>
            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>" required minlength="2">

            <label for="lastname"><?= t('player_lastName') ?> :</label>
            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>" required minlength="2">

            <label for="country"><?= t('player_country') ?> :</label>
            <input type="text" id="country" name="country" value="<?= htmlspecialchars($country) ?>" required minlength="2">

            <label for="club"><?= t('player_club') ?> :</label>
            <input type="text" id="club" name="club" value="<?= htmlspecialchars($club) ?>" required minlength="2">

            <label for="position"><?= t('player_position') ?> :</label>
            <input type="text" id="position" name="position" value="<?= htmlspecialchars($position) ?>" required minlength="2">

            <label for="team_id"><?= t('player_team') ?> :</label>
            <select id="team_id" name="team_id" required>
                <option value="">-- <?= t('select') ?> --</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team->getId(); ?>" <?= ($team_id == $team->getId()) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($team->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"><?= t('update_player') ?></button>
        </form>
    </main>
</body>

</html>