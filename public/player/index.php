<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager; 

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

$players = $playersManager->getPlayers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title>Gestion des joueurs | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Gestion des joueurs</h1>

        <p><a href="../index.php">Accueil</a> > Gestion des joueurs</p>

        <h2>Liste des joueurs</h2>

        <p><a href="createPlayer.php"><button>Créer un nouveau joueur</button></a></p>

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Country</th>
                    <th>Club</th>
                    <th>Position</th>
                    <th>Équipe</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player) { ?>
                    <tr>
                        <td><?= htmlspecialchars($player->getFirstName()) ?></td>
                        <td><?= htmlspecialchars($player->getLastName()) ?></td>
                        <td><?= htmlspecialchars($player->getCountry()) ?></td>
                        <td><?= htmlspecialchars($player->getClub()) ?></td>
                        <td><?= htmlspecialchars($player->getPosition()) ?></td>
                         <td><!-- permet d'afficher le nom de l'équipe et pas simplement le numéro, plus joli !-->
                            <?php 
                            $team = null;
                            foreach ($teams as $t) {
                                if ($t->getId() === $player->getTeamId()) {
                                    $team = $t;
                                    break;
                                }
                            }
                            echo htmlspecialchars($team ? $team->getName() : 'Aucune équipe');
                            ?>
                        </td> 
                        <td>
                            <a href="deletePlayer.php?id=<?= htmlspecialchars($player->getId()) ?>"><button>Supprimer</button></a>
                            <a href="editPlayer.php?id=<?= htmlspecialchars($player->getId()) ?>"><button>Modifier</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>