<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Team\TeamsManager;
use Team\Team;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireLogin();

$teamsManager = new TeamsManager();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $nbPlayers = $_POST["nbPlayers"];
    $descr = $_POST["descr"];
    $sport = $_POST["sport"];

    $errors = [];

    try {
        $team = new Team(
            null,
            $name,
            (int)$nbPlayers,
            $descr,
            $sport
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }

    if (empty($errors)) {
        try {
            $teamId = $teamsManager->addTeam($team, $currentUserId);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            //de la part de Romain, le 23000 c'est si y a une violation de contrainte de la bd
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
    <link rel="stylesheet" href="../css/custom.css">
    <title><?= t('create_team') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('create_team') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="index.php"><?= t('teams_management') ?></a> > <?= t('create_team') ?></p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;"><?= t('team_created_success') ?></p>
            <?php } else { ?>
                <p style="color: red;"><?= t('form_error') ?></p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="createTeam.php" method="POST">
            <label for="name"><?= t('team_name') ?></label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? ''); ?>" required minlength="2">

            <label for="nbPlayers"><?= t('team_nbPlayers') ?></label>
            <input type="number" id="nbPlayers" name="nbPlayers" value="<?= htmlspecialchars($nbPlayers ?? ''); ?>" required min="1">

            <label for="descr"><?= t('team_description') ?></label>
            <textarea id="descr" name="descr" rows="3"><?= htmlspecialchars($descr ?? ''); ?></textarea>

            <label for="sport"><?= t('team_sport') ?></label>
            <input type="text" id="sport" name="sport" value="<?= htmlspecialchars($sport ?? ''); ?>" required>

            <button type="submit"><?= t('create_team') ?></button>
        </form>
    </main>
</body>

</html>