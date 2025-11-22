<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';
 
session_start();
 
$isLoggedIn = isset($_SESSION['user_id']);
$userFirstname = $_SESSION['firstname'] ?? '';
 
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
 
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
        <link rel="stylesheet" href="css/custom.css">
        <title><?= t('home') ?> | <?= t('teams_management') ?></title>
        <style>
                .menu-container {
                        display: flex;
                        gap: 2rem;
                        margin-bottom: 1.5rem;
                        flex-wrap: wrap;
                }

                .menu-section {
                        flex: 1;
                        min-width: 250px;
                }

                .menu-buttons {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.5rem;
                        margin-bottom: 1.5rem;
                }
 
                .menu-buttons a button {
                        padding: 0.3rem 0.7rem;
                        font-size: 0.85rem;
                        border-radius: 0.5rem;
                }
 
                .menu-section h2 {
                        margin-bottom: 0.5rem;
                        font-size: 1.2rem;
                }
        </style>
</head>
 
<body>
        <main class="container">
                <h1><?= t('welcome_title') ?></h1>

                <h3><?= t('hero_subtitle') ?></h3>
                <p><?= t('hero_paragraph') ?></p>
 
                <div class="menu-container">
                        <section class="menu-section">
                                <h2><?= t('public_access') ?></h2>
                                <div class="menu-buttons">
                                        <!-- Raul, tu peux mettre ici le lien vers la page des règles et remplacer "page public"!-->
                                        <a href="public.php"><button><?= t('public_page') ?></button></a>
                                        <a href="team/index.php"><button><?= t('view_teams') ?></button></a>
                                        <a href="player/index.php"><button><?= t('view_players') ?></button></a>
                                </div>
                        </section>
 

                        <section class="menu-section">
                                <h2><?= t('authentication') ?></h2>
                                <div class="menu-buttons">
                                        <?php if (!$isLoggedIn) { ?>
                                                        <a href="auth/login.php"><button><?= t('login') ?></button></a>
                                                        <a href="auth/register.php"><button><?= t('create_account') ?></button></a>
                                        <?php } else { ?>
                                                        <a href="auth/logout.php"><button><?= t('logout') ?></button></a>
                                        <?php } ?>
                                </div>
                        </section>
                </div>
                <?php if ($isLoggedIn) { ?>
                        <section class="menu-section">
                                        <h2><?= t('my_areas') ?></h2>
                                <div class="menu-buttons">
                                                <a href="profile.php"><button><?= t('my_profile') ?></button></a>
                                                <a href="dashboard.php"><button><?= t('dashboard_label') ?></button></a>
                                                <a href="resources.php"><button><?= t('resources_label') ?></button></a>
                                </div>
                        </section>
                <?php } ?>
                <hr>
                <form method="get" style="margin-top: 1em;">
                        <label for="lang"><?= t('choose_language') ?> :</label>
                        <select name="lang" id="lang" onchange="this.form.submit()">
                                <option value="fr" <?= ($language === 'fr') ? 'selected' : '' ?>>Français</option>
                                <option value="en" <?= ($language === 'en') ? 'selected' : '' ?>>English</option>
                        </select>
                </form>
 
                <p style="font-size: 0.9em; color: gray;"><?= t('current_language') ?> <?= strtoupper($language) ?></p>
        </main>
</body>
 
</html>