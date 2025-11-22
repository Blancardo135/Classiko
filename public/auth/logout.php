<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

// Démarrer la session
session_start();

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: login.php');
    exit();
}

// Détruit la session
session_destroy();
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('logout_title') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('logout_title') ?></h1>

        <p><?= t('logout_success') ?></p>

        <p><a href="../index.php"><?= t('back_home') ?></a> | <a href="login.php"><?= t('login_again') ?></a></p>
    </main>
</body>

</html>