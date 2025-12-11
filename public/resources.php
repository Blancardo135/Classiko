<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'] ?? '';
$lastname = $_SESSION['lastname'] ?? '';
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('resources_label') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('resources_label') ?></h1>

        <p><?= t('resources_paragraph') ?></p>
      

        <section>
            <h2><?= t('teams_section') ?></h2>
            <p><?= t('manage_your_teams') ?></p>
            <p>
                <a href="team/index.php"><button><?= t('view_all_teams') ?></button></a>
                <a href="team/createTeam.php"><button><?= t('create_team_button') ?></button></a>
            </p>
        </section>

        <section>
            <h2><?= t('players_section') ?></h2>
            <p><?= t('manage_your_players') ?></p>
            <p>
                <a href="player/index.php"><button><?= t('view_all_players') ?></button></a>
                <a href="player/createPlayer.php"><button><?= t('create_player_button') ?></button></a>
            </p>
        </section>

        <section>
            <h2><?= t('navigation') ?></h2>
            <p>
                <a href="index.php"><button><?= t('home') ?></button></a>
                <a href="auth/logout.php"><button><?= t('logout') ?></button></a>
            </p>
        </section>
    </main>
</body>

</html>
