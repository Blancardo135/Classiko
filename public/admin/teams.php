<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Team\TeamsManager;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireAdmin();

$teamsManager = new TeamsManager();
$teams = $teamsManager->getAllTeamsWithOwner();
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../css/custom.css">

    <title><?= t('admin_panel_title') ?> — <?= t('teams_management') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('admin_panel') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="users.php"><?= t('admin_panel') ?></a> > <?= t('teams_management') ?></p>

        <h2><?= t('all_teams') ?></h2>

        <?php if (empty($teams)): ?>
            <p><?= t('not_found') ?></p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th><?= t('team_name') ?></th>
                    <th><?= t('team_sport') ?></th>
                    <th><?= t('team_nbPlayers') ?></th>
                    <th><?= t('label_email') ?> (<?= t('label_id') ?>)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teams as $team): ?>
                    <tr>
                        <td><?= htmlspecialchars($team['name']) ?></td>
                        <td><?= htmlspecialchars($team['sport']) ?></td>
                        <td><?= $team['nbPlayers'] ?></td>
                        <td>
                            <?php if (!empty($team['owner_email'])): ?>
                                <?= htmlspecialchars($team['owner_email']) ?> (<?= htmlspecialchars($team['owner_firstname'] . ' ' . $team['owner_lastname']) ?>)
                            <?php else: ?>
                                <em><?= t('not_found') ?></em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <p>
            <a href="users.php"><button><?= t('admin_panel') ?></button></a>
            <a href="players.php"><button><?= t('players_management') ?></button></a>
            <a href="../index.php"><button><?= t('home') ?></button></a>
        </p>
    </main>
</body>

</html>
