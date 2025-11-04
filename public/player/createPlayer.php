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

$errors = [];
$firstname = $lastname = $country = $club = $position = $team_id = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $country = $_POST['country'];
    $club = $_POST['club'];
    $position = $_POST['position'];
    $team_id = $_POST['team_id'];
    try {
        $player = new Player(
            null,
            $firstname,
            $lastname,
            $country,
            $club,
            $position,
            (int)$team_id
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }
    if (empty($errors)) {
        try {
            $playerId = $playersManager->addPlayer($player);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $errors[] = t('tool_exists');
            } else {
                $errors[] = t('db_error') . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = t('unexpected_error') . $e->getMessage();
        }
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

    <title><?= t('create_newPlayer') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('create_newPlayer') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="index.php"><?= t('players_management') ?></a> > <?= t('create_newPlayer') ?></p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;"><?= t('player_created_success') ?></p>
            <?php } else { ?>
                <p style="color: red;"><?= t('form_error') ?></p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="createPlayer.php" method="POST">
            <label for="firstname"><?= t('player_firstName') ?></label>
            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname); ?>" required minlength="2">

            <label for="lastname"><?= t('player_lastName') ?></label>
            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname); ?>" required minlength="2">

            <label for="country"><?= t('player_country') ?></label>
            <input type="text" id="country" name="country" value="<?= htmlspecialchars($country); ?>" required minlength="2">

            <label for="club"><?= t('player_club') ?></label>
            <input type="text" id="club" name="club" value="<?= htmlspecialchars($club); ?>" required minlength="2">

            <label for="position"><?= t('player_position') ?></label>
            <input type="text" id="position" name="position" value="<?= htmlspecialchars($position); ?>" required minlength="2">

            <label for="team_id"><?= t('player_team') ?> :
                <select id="team_id" name="team_id" required>
                    <option value="">-- <?= t('select') ?> --</option>
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?= $team->getId(); ?>" <?= ($team_id == $team->getId()) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($team->getName()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <button type="submit"><?= t('create_player') ?></button>
        </form>
    </main>
</body>

</html>