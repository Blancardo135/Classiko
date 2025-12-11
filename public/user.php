<?php

const DATABASE_FILE = __DIR__ . '/../teamsmanager.db';

require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    
    header('Location: auth/login.php');
    exit();
}


if ($_SESSION['role'] !== 'author') {
    
    header('Location: 403.php');
    exit();
}

$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('user_space_title') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('user_space') ?></h1>

        <p><?= t('user_only_page') ?></p>

        <p><a href="index.php"><?= t('return_home') ?></a> | <a href="./auth/logout.php"><?= t('logout') ?></a></p>
    </main>
</body>

</html>