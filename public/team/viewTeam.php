<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Team\TeamsManager;

$teamsManager = new TeamsManager();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$teamId = (int) $_GET['id'];
$team = $teamsManager->getTeamById($teamId);

if (!$team) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="UTF-8">
    <title><?= t('view_details') ?> : <?= htmlspecialchars($team->getName()) ?></title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.5.10/css/pico.min.css">
</head>

<body class="container">
    <main>
        <h1><?= t('view_details') ?></h1>

        <article>
            <h2><?= htmlspecialchars($team->getName()) ?></h2>
            <p><strong><?= t('team_sport') ?> :</strong> <?= htmlspecialchars($team->getSport()) ?></p>
            <p><strong><?= t('team_nbPlayers') ?> :</strong> <?= $team->getNbPlayers() ?></p>
            <p><strong><?= t('team_description') ?> :</strong></p>
            <p><?= nl2br(htmlspecialchars($team->getDescr())) ?></p>
        </article>

        <p>
            <a href="index.php" role="button"><?= t('home') ?></a>
            <a href="editTeam.php?id=<?= $team->getId() ?>" role="button"><?= t('edit_team') ?></a>
        </p>
    </main>
</body>

</html>