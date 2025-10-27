<?php
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php'; // si tu veux aussi les joueurs

$teamsManager = new TeamsManager();
$playersManager = new PlayersManager();

$teams = $teamsManager->getAllTeams();
$players = $playersManager->getPlayers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestionnaire d'équipes et de joueurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            color: #333;
        }
        h1 { text-align: center; color: #444; }
        .section {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .team-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            background: #fefefe;
        }
        .team-card h3 {
            color: #5cb85c;
            margin: 0 0 5px 0;
        }
        .btn {
            background: #5cb85c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn:hover { background: #4cae4c; }
        .empty {
            text-align: center;
            padding: 40px;
            color: #888;
            border: 2px dashed #ccc;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <h1>⚽ Gestionnaire d'équipes et de joueurs</h1>

    <div class="section">
        <h2>🏆 Mes équipes</h2>

        <?php if (empty($teams)): ?>
            <div class="empty">
                <p>Aucune équipe enregistrée pour le moment.</p>
                <a class="btn" href="createTeam.php">Créer ma première équipe</a>
            </div>
        <?php else: ?>
            <?php foreach ($teams as $team): ?>
                <div class="team-card">
                    <h3><?= htmlspecialchars($team->getName()) ?></h3>
                    <p><strong>Sport :</strong> <?= htmlspecialchars($team->getSport()) ?></p>
                    <p><strong>Nombre de joueurs :</strong> <?= htmlspecialchars($team->getNbPlayers()) ?></p>
                    <?php if (!empty($team->getDescr())): ?>
                        <p><strong>Description :</strong> <?= htmlspecialchars($team->getDescr()) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>👥 Mes joueurs</h2>
        <?php if (empty($players)): ?>
            <div class="empty">
                <p>Aucun joueur enregistré.</p>
                <a class="btn" href="createPlayer.php">Ajouter un joueur</a>
            </div>
        <?php else: ?>
            <?php foreach ($players as $player): ?>
                <div class="team-card">
                    <h3><?= htmlspecialchars($player['firstname']) ?> <?= htmlspecialchars($player['lastname']) ?></h3>
                    <p><strong>Club :</strong> <?= htmlspecialchars($player['club']) ?></p>
                    <p><strong>Pays :</strong> <?= htmlspecialchars($player['country']) ?></p>
                    <p><strong>Poste :</strong> <?= htmlspecialchars($player['position']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>