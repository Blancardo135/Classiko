<?php
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php';

$teamsManager = new TeamsManager();
$playersManager = new PlayersManager();

$teams = $teamsManager->getAllTeams();
$players = $playersManager->getAllPlayers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        h1 { margin-bottom: 1rem; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 2rem; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        th { background-color: #f2f2f2; }
        a.button {
            background-color: #4CAF50; color: white;
            padding: 0.5rem 1rem; text-decoration: none;
            border-radius: 4px;
        }
        .section { margin-bottom: 3rem; }
    </style>
</head>
<body>

    <h1>Gestion des Équipes & Joueurs</h1>

    <div class="section">
        <h2>Équipes</h2>
        <a href="createTeam.php" class="button">➕ Ajouter une équipe</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Pays</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($teams)): ?>
                    <tr><td colspan="5">Aucune équipe trouvée.</td></tr>
                <?php else: ?>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td><?= $team->getId(); ?></td>
                            <td><?= htmlspecialchars($team->getName()); ?></td>
                            <td><?= htmlspecialchars($team->getCountry()); ?></td>
                            <td><?= htmlspecialchars($team->getCity()); ?></td>
                            <td><a href="editTeam.php?id=<?= $team->getId(); ?>">Modifier</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Joueurs</h2>
        <a href="createPlayer.php" class="button">➕ Ajouter un joueur</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Club</th>
                    <th>Pays</th>
                    <th>Position</th>
                    <th>Équipe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($players)): ?>
                    <tr><td colspan="8">Aucun joueur trouvé.</td></tr>
                <?php else: ?>
                    <?php foreach ($players as $player): ?>
                        <?php
                            $team = $teamsManager->getTeam($player->getTeamId());
                            $teamName = $team ? htmlspecialchars($team->getName()) : 'Équipe inconnue';
                        ?>
                        <tr>
                            <td><?= $player->getId(); ?></td>
                            <td><?= htmlspecialchars($player->getFirstname()); ?></td>
                            <td><?= htmlspecialchars($player->getLastname()); ?></td>
                            <td><?= htmlspecialchars($player->getClub()); ?></td>
                            <td><?= htmlspecialchars($player->getCountry()); ?></td>
                            <td><?= htmlspecialchars($player->getPosition()); ?></td>
                            <td><?= $teamName; ?></td>
                            <td><a href="editPlayer.php?id=<?= $player->getId(); ?>">Modifier</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>