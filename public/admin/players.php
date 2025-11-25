<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Player\PlayersManager;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireAdmin();

$playersManager = new PlayersManager();
$players = $playersManager->getAllPlayersWithOwner();
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../css/custom.css">

    <title><?= t('admin_panel_title') ?> — <?= t('players_management') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('admin_panel') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="users.php"><?= t('admin_panel') ?></a> > <?= t('players_management') ?></p>

        <h2><?= t('all_players') ?></h2>

        <table>
            <thead>
                <tr>
                    <th><?= t('player_firstName') ?></th>
                    <th><?= t('player_lastName') ?></th>
                    <th><?= t('player_country') ?></th>
                    <th><?= t('player_club') ?></th>
                    <th><?= t('player_position') ?></th>
                    <th><?= t('label_email') ?> (<?= t('label_id') ?>)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player['firstname']) ?></td>
                        <td><?= htmlspecialchars($player['lastname']) ?></td>
                        <td><?= htmlspecialchars($player['country']) ?></td>
                        <td><?= htmlspecialchars($player['club']) ?></td>
                        <td><?= htmlspecialchars($player['position']) ?></td>
                        <td>
                            <?php if (!empty($player['owner_email'])): ?>
                                <?= htmlspecialchars($player['owner_email']) ?> (<?= htmlspecialchars($player['owner_firstname'] . ' ' . $player['owner_lastname']) ?>)
                            <?php else: ?>
                                <em><?= t('not_found') ?></em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <a href="users.php"><button><?= t('admin_panel') ?></button></a>
            <a href="teams.php"><button><?= t('teams_management') ?></button></a>
            <a href="../index.php"><button><?= t('home') ?></button></a>
        </p>
    </main>
</body>

</html>
