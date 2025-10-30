<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID du joueur invalide.");
}

$playerId = (int) $_GET['id'];
$player = $playersManager->getPlayerById($playerId);

if (!$player) {
    die("Joueur non trouvé.");
}


$firstname = $player->getFirstname();
$lastname = $player->getLastname();
$country = $player->getCountry();
$club = $player->getClub();
$position = $player->getPosition();
$team_id = $player->getTeamId();

$teamName = '';
foreach ($teams as $team) {
    if ($team->getId() == $team_id) {
        $teamName = $team->getName();
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title>Détails du joueur | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Détails du joueur</h1>

        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des joueurs</a> > Détails du joueur</p>

        <table>
            <tbody>
                <tr>
                    <th>Prénom</th>
                    <td><?= htmlspecialchars($firstname); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?= htmlspecialchars($lastname); ?></td>
                </tr>
                <tr>
                    <th>Pays</th>
                    <td><?= htmlspecialchars($country); ?></td>
                </tr>
                <tr>
                    <th>Club</th>
                    <td><?= htmlspecialchars($club); ?></td>
                </tr>
                <tr>
                    <th>Position</th>
                    <td><?= htmlspecialchars($position); ?></td>
                </tr>
                <tr>
                    <th>Équipe</th>
                    <td><?= htmlspecialchars($teamName); ?></td>
                </tr>
            </tbody>
        </table>

        <p>
            <a href="editPlayer.php?id=<?= $playerId ?>"><button>Modifier</button></a>
            <a href="deletePlayer.php?id=<?= $playerId ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce joueur ?');"><button>Supprimer</button></a>
            <a href="index.php"><button>Retour à la liste</button></a>
        </p>
    </main>
</body>

</html>
