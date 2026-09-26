<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';
require_once __DIR__ . '/../src/functions.php';

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
<html lang="<?= $language ?? 'fr' ?>">

<?php render('head', [
    'title' => t('dashboard_title') . ' | ' . t('teams_management'),
    'description' => t('dashboard_title') . ' - ' . t('teams_management'),
]); ?>

<body>
    <?php render('header'); ?>
    <main class="container">
        <h1><?= t('dashboard_title') ?></h1>

        <p><?= t('private_space') ?></p>

        <section>
            <h2><?= sprintf(t('welcome_user'), htmlspecialchars($firstname)) ?></h2>
            <p><?= sprintf(t('you_are_logged_as'), '<strong>' . htmlspecialchars($role) . '</strong>') ?></p>
        </section>

        <section>
            <h2><?= t('check_your_creations') ?></h2>
            
            <p>
                <a href="team/index.php"><button><?= t('view_teams') ?></button></a>
                <a href="player/index.php"><button><?= t('view_players') ?></button></a>
            </p>
        </section>

        <section>
            <h2><?= t('actions') ?></h2>
            <p>
                <a href="index.php"><button><?= t('home') ?></button></a>
                <a href="auth/logout.php"><button><?= t('logout') ?></button></a>
            </p>
        </section>
    </main>
    <?php render('footer'); ?>
</body>

</html>
