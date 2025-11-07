<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';


//page publique
session_start();


$userId = $_SESSION['user_id'] ?? null;


if ($userId) {
        $email = $_SESSION['email'];
        $role = $_SESSION['role'];
}


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
</head>

<body>
        <main class="container">
                <h1><?= t('teams_management') ?></h1>

                <p><?= t('welcome') ?></p>

                <p><a href="team/index.php"><button><?= t('view_teams') ?></button></a></p>
                <p><a href="player/index.php"><button><?= t('view_players') ?></button></a></p>

                <!--Partie sur l'authentification et session, mis le 05.11-->

                <h2>Pages publiques</h2>
                <div class="grid">
                        <a href="auth/register.php"><button>Créer un compte</button></a>
                        <a href="auth/login.php"><button>Se connecter</button></a>
                        <a href="public.php"><button>Page publique</button></a>
                </div>

                <h2>Pages protégées</h2>
                <div class="grid">
                        <a href="user.php"><button>Espace utilisateur</button></a>
                        <a href="auth/logout.php"><button>Se déconnecter</button></a>
                </div>

                <!-- cookie langue -->
                <hr>
                <form method="get" style="margin-top: 1em;">
                        <label for="lang"><?= t('choose_language') ?> :</label>
                        <select name="lang" id="lang" onchange="this.form.submit()">
                                <option value="fr" <?= ($language === 'fr') ? 'selected' : '' ?>>Français</option>
                                <option value="en" <?= ($language === 'en') ? 'selected' : '' ?>>English</option>
                        </select>
                </form>

                <p style="font-size: 0.9em; color: gray;"><?= t('current_language') ?> <?= strtoupper($language) ?></p>
                <!-- cookie langue -->
        </main>
</body>

</html>