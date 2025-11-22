<?php

require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = t('error_required_fields');
    } else {
        try {
            $userManager = new userManager();
            $user = $userManager->verifyUser($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'] ?? '';
                $_SESSION['lastname'] = $user['lastname'] ?? '';
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                header('Location: ../index.php');
                exit();
            } else {
                $error = t('error_invalid_credentials');
            }
        } catch (Exception $e) {
            $error = t('error_occurred') . ': ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('login_title') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('login_heading') ?></h1>

        <?php if ($error): ?>
            <article style="background-color: var(--pico-del-color);">
                <p><strong><?= t('error_occurred') ?> :</strong> <?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <form method="post">
            <label for="email">
                <?= t('email_label') ?>
                <input type="email" id="email" name="email" required autofocus>
            </label>

            <label for="password">
                <?= t('password_label') ?>
                <input type="password" id="password" name="password" required>
            </label>

            <button type="submit"><?= t('login_button') ?></button>
        </form>

        <p><?= t('no_account') ?> <a href="register.php"><?= t('create_account') ?></a></p>

        <p><a href="../index.php"><?= t('back_home') ?></a></p>
    </main>
</body>

</html>