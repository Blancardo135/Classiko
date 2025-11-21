<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;
use Database;

session_start();
$currentUserId = $_SESSION['user_id'] ?? null;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die(t('no_player_id'));
}

$playerId = (int) $_GET['id'];


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

$teamName = '';
foreach ($teams as $team) {
    if ($team->getId() == $team_id) {
        $teamName = $team->getName();
        break;
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

    <title><?= t('view_details') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('view_details') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="index.php"><?= t('players_management') ?></a> > <?= t('view_details') ?></p>

        <table>
            <tbody>
                <tr>
                    <th><?= t('player_firstName') ?></th>
                    <td><?= htmlspecialchars($firstname); ?></td>
                </tr>
                <tr>
                    <th><?= t('player_lastName') ?></th>
                    <td><?= htmlspecialchars($lastname); ?></td>
                </tr>
                <tr>
                    <th><?= t('player_country') ?></th>
                    <td><?= htmlspecialchars($country); ?></td>
                </tr>
                <tr>
                    <th><?= t('player_club') ?></th>
                    <td><?= htmlspecialchars($club); ?></td>
                </tr>
                <tr>
                    <th><?= t('player_position') ?></th>
                    <td><?= htmlspecialchars($position); ?></td>
                </tr>
                <tr>
                    <th><?= t('player_team') ?></th>
                    <td><?= htmlspecialchars($teamName); ?></td>
                </tr>
            </tbody>
        </table>

        <p>
            <a href="editPlayer.php?id=<?= $playerId ?>"><button><?= t('edit_player') ?></button></a>
            <a href="deletePlayer.php?id=<?= $playerId ?>" onclick="return confirm('<?= t('delete_player') ?> ?');"><button><?= t('delete_player') ?></button></a>
            <a href="index.php"><button><?= t('home') ?></button></a>
        </p>
    </main>
</body>

</html>