<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

$players = $playersManager->getPlayers();

//Page privée

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: auth/login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title><?= t('players_management') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('players_management') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <?= t('players_management') ?></p>

        <h2><?= t('players_list') ?></h2>

        <p><a href="createPlayer.php"><button><?= t('create_newPlayer') ?></button></a></p>

        <table>
            <thead>
                <tr>
                    <th><?= t('player_firstName') ?></th>
                    <th><?= t('player_lastName') ?></th>
                    <th><?= t('player_country') ?></th>
                    <th><?= t('player_club') ?></th>
                    <th><?= t('player_position') ?></th>
                    <th><?= t('player_team') ?></th>
                    <th><?= t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player) { ?>
                    <tr>
                        <td><?= htmlspecialchars($player->getFirstName()) ?></td>
                        <td><?= htmlspecialchars($player->getLastName()) ?></td>
                        <td><?= htmlspecialchars($player->getCountry()) ?></td>
                        <td><?= htmlspecialchars($player->getClub()) ?></td>
                        <td><?= htmlspecialchars($player->getPosition()) ?></td>
                        <td>
                            <?php
                            $team = null;
                            foreach ($teams as $t) {
                                if ($t->getId() === $player->getTeamId()) {
                                    $team = $t;
                                    break;
                                }
                            }
                            echo htmlspecialchars($team ? $team->getName() : t('not_found'));
                            ?>
                        </td>
                        <td>
                            <a href="editPlayer.php?id=<?= htmlspecialchars($player->getId()) ?>"><button><?= t('edit_player') ?></button></a>
                            <a href="deletePlayer.php?id=<?= htmlspecialchars($player->getId()) ?>"><button><?= t('delete_player') ?></button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>