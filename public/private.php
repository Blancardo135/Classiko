<?php

session_start();

require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';
require_once __DIR__ . '/../src/utils/auth.php';


$userId = $_SESSION['user_id'] ?? null;


if (!$userId) {
    
    header('Location: auth/login.php');
    exit();
}
$email = $_SESSION['email'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('user_space_title') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('user_space_title') ?></h1>

        <p><?= t('user_only_page') ?></p>

        <section>
            <h2><?= t('you_are_currently_logged_in') ?></h2>
            <ul>
                <li><strong><?= t('label_id') ?> :</strong> <?= htmlspecialchars($userId) ?></li>
                <li><strong><?= t('label_firstname') ?> :</strong> <?= htmlspecialchars($_SESSION['firstname'] ?? '') ?></li>
                <li><strong><?= t('label_lastname') ?> :</strong> <?= htmlspecialchars($_SESSION['lastname'] ?? '') ?></li>
                <li><strong><?= t('label_email') ?> :</strong> <?= htmlspecialchars($email) ?></li>
                <li><strong><?= t('label_role') ?> :</strong> <strong><?= htmlspecialchars($role) ?></strong></li>
            </ul>
        </section>

        <section>
            <h2><?= t('navigation') ?></h2>
            <p>
                <a href="profile.php"><button><?= t('my_profile') ?></button></a>
                <a href="dashboard.php"><button><?= t('dashboard_label') ?></button></a>
                <a href="resources.php"><button><?= t('resources_label') ?></button></a>
                <a href="index.php"><button><?= t('home') ?></button></a>
                <a href="auth/logout.php"><button><?= t('logout') ?></button></a>
            </p>
        </section>
    </main>
</body>

</html>