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
                .menu-buttons {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.5rem;
                        margin-bottom: 1.5rem;
                }

                .menu-buttons a button {
                        padding: 0.4rem 0.8rem;
                        font-size: 0.9rem;
                        border-radius: 0.5rem;
                }

                .menu-section h2 {
                        margin-bottom: 0.5rem;
                }
        </style>
</head>

<body>
        <main class="container">
                <h1><?= t('teams_management') ?></h1>

                <p><?= t('welcome') ?></p>

                <p><a href="/public/team/index.php"><button>Voir les équipes</button></a></p>
                <p><a href="player/index.php"><button>Voir les joueurs</button></a></p>

                <!-- Pages Publiques -->
                <section class="menu-section">
                    <h2>Pages Publiques</h2>
                    <div class="menu-buttons">
                        <a href="public.php"><button>Page Publique</button></a>
                        <a href="team/index.php"><button>Voir les Équipes</button></a>
                        <a href="player/index.php"><button>Voir les Joueurs</button></a>
                    </div>
                </section>

                <!-- Authentification -->
                <section class="menu-section">
                    <h2>Authentification</h2>
                    <div class="menu-buttons">
                        <?php if (!$isLoggedIn) { ?>
                            <a href="auth/login.php"><button>Se Connecter</button></a>
                            <a href="auth/register.php"><button>Créer un Compte</button></a>
                        <?php } else { ?>
                            <a href="auth/logout.php"><button>Se Déconnecter</button></a>
                        <?php } ?>
                    </div>
                </section>

                <!-- Pages Privées (si connecté) -->
                <?php if ($isLoggedIn) { ?>
                <section class="menu-section">
                    <h2>Mes différents espaces</h2>
                    <div class="menu-buttons">
                        <a href="private.php"><button>Page Privée</button></a>
                        <a href="profile.php"><button>Mon Profil</button></a>
                        <a href="dashboard.php"><button>Mon Tableau de Bord</button></a>
                        <a href="resources.php"><button>Mes Ressources</button></a>
                    </div>
                </section>
                <?php } ?>                <!-- cookie langue -->
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