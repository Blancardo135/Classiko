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
    <title><?= t('my_profile') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('my_profile') ?></h1>

        

        <section>
            <h2><?= t('account_info') ?></h2>
            <table>
                <tbody>
                    <tr>
                        <td><strong><?= t('label_id') ?> :</strong></td>
                        <td><?= htmlspecialchars($userId) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?= t('label_firstname') ?> :</strong></td>
                        <td><?= htmlspecialchars($firstname) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?= t('label_lastname') ?> :</strong></td>
                        <td><?= htmlspecialchars($lastname) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?= t('label_email') ?> :</strong></td>
                        <td><?= htmlspecialchars($email) ?></td>
                    </tr>
                    <tr>
                        <td><strong><?= t('label_role') ?> :</strong></td>
                        <td><strong><?= htmlspecialchars($role) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h2><?= t('actions') ?></h2>
            <p>
                <a href="dashboard.php"><button><?= t('dashboard_label') ?></button></a>
            <a href="index.php"><button><?= t('home') ?></button></a>
                <a href="auth/logout.php"><button><?= t('logout') ?></button></a>
            </p>
        </section>
    </main>
</body>

</html>
