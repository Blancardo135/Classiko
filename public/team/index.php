<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Team\TeamsManager;
use Team\Team;

$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

//Page privée

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: auth/login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title><?= t('teams_management') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('teams_management') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <?= t('teams_management') ?></p>

        <h2><?= t('teams_list') ?></h2>

        <p><a href="createTeam.php"><button><?= t('add_team') ?></button></a></p>

        <table>
            <thead>
                <tr>
                    <th><?= t('team_name') ?></th>
                    <th><?= t('team_sport') ?></th>
                    <th><?= t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teams as $team) { ?>
                    <tr>
                        <td><?= htmlspecialchars($team->getName()) ?></td>
                        <td><?= htmlspecialchars($team->getSport()) ?></td>
                        <td>
                            <a href="editTeam.php?id=<?= htmlspecialchars($team->getId()) ?>"><button><?= t('edit_team') ?></button></a>
                            <a href="deleteTeam.php?id=<?= htmlspecialchars($team->getId()) ?>"><button><?= t('delete_team') ?></button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>