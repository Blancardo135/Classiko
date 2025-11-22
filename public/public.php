<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';

session_start();


$userId = $_SESSION['user_id'] ?? null;


if ($userId) {
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('public_page') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('public_page') ?></h1>

        <p><?= t('public_page_paragraph') ?></p>

        <?php if ($userId) { ?>
            <p><strong><?= t('you_are_currently_logged_in') ?></strong> :</p>
            <ul>
                <li><strong><?= t('label_id') ?> :</strong> <?= htmlspecialchars($userId) ?></li>
                <li><strong><?= t('label_email') ?> :</strong> <?= htmlspecialchars($email) ?></li>
                <li><strong><?= t('label_role') ?> :</strong> <?= htmlspecialchars($role) ?></li>
            </ul>
        <?php } else { ?>
            <p><strong><?= t('you_are_not_logged_in') ?></strong></p>
        <?php } ?>

        <p>
            <a href="index.php"><?= t('return_home') ?></a>
            <?php if ($userId) { ?>
                | <a href="auth/logout.php"><?= t('logout') ?></a>
            <?php } else { ?>
                | <a href="auth/login.php"><?= t('login') ?></a>
                | <a href="auth/register.php"><?= t('create_account') ?></a>
            <?php } ?>
        </p>
    </main>
</body>

</html>