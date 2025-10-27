<?php
// Page d'accueil - Gestionnaire d'équipes et de joueurs
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php';

$teamsManager = new TeamsManager();
$playersManager = new PlayersManager();

// Méthodes corrigées pour correspondre à ta classe TeamsManager
$teams = $teamsManager->getTeams();
$players = $playersManager->getPlayers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire d'équipes et de joueurs</title>

    <style>
        /* CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            color: #444;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 18px;
        }

        .main-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .main-actions a {
            text-decoration: none;
        }

        .btn {
            padding: 15px 30px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .btn:hover {
            background-color: #4cae4c;
        }

        .btn-secondary {
            background-color: #5bc0de;
        }

        .btn-secondary:hover {
            background-color: #46b8da;
        }

        .content-section {
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #5cb85c;
        }

        .section-header h2 {
            color: #444;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            color: #5cb85c;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .card-info {
            margin: 8px 0;
            color: #666;
        }

        .card-info strong {
            color: #444;
        }

        .card-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .card-actions a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            transition: opacity 0.3s;
        }

        .card-actions a:hover {
            opacity: 0.8;
        }

        .btn-view {
            background-color: #5bc0de;
            color: white;
        }

        .btn-edit {
            background-color: #f0ad4e;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            background: white;
            border: 2px dashed #ddd;
            border-radius: 5px;
            color: #999;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
    </style>
</head>

<body>
    <header>
        <h1>⚽ Gestionnaire d'équipes et de joueurs</h1>
        <p class="subtitle">Gérez vos équipes favorites et vos joueurs préférés</p>
    </header>

    <div class="main-actions">
        <a href="createTeam.php"><button class="btn">➕ Créer une nouvelle équipe</button></a>
        <a href="createPlayer.php"><button class="btn btn-secondary">➕ Ajouter un nouveau joueur</button></a>
    </div>

    <!-- Section Équipes -->
    <div class="content-section">
        <div class="section-header">
            <h2>🏆 Mes Équipes</h2>
            <span><?= count($teams) ?> équipe(s)</span>
        </div>

        <?php if (empty($teams)): ?>
            <div class="empty-state">
                <p>Aucune équipe enregistrée pour le moment</p>
                <a href="createTeam.php"><button class="btn">Créer ma première équipe</button></a>
            </div>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($teams as $team): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($team['name']) ?></h3>
                        <div class="card-info"><strong>Sport:</strong> <?= htmlspecialchars($team['sport']) ?></div>
                        <div class="card-info"><strong>Nombre de joueurs:</strong> <?= htmlspecialchars($team['nbPlayers']) ?></div>
                        <?php if (!empty($team['descr'])): ?>
                            <div class="card-info">
                                <strong>Description:</strong>
                                <?= htmlspecialchars(substr($team['descr'], 0, 100)) ?><?= strlen($team['descr']) > 100 ? '...' : '' ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section Joueurs -->
    <div class="content-section">
        <div class="section-header">
            <h2>👥 Mes Joueurs</h2>
            <span><?= count($players) ?> joueur(s)</span>
        </div>

        <?php if (empty($players)): ?>
            <div class="empty-state">
                <p>Aucun joueur enregistré pour le moment</p>
                <a href="createPlayer.php"><button class="btn btn-secondary">Ajouter mon premier joueur</button></a>
            </div>
        <?php else: ?>
            <div class="grid">
                <?php foreach ($players as $player): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($player['name']) ?> <?= htmlspecialchars($player['surname']) ?></h3>
                        <div class="card-info"><strong>Position:</strong> <?= htmlspecialchars($player['position']) ?></div>
                        <div class="card-info"><strong>Club:</strong> <?= htmlspecialchars($player['club']) ?></div>
                        <?php if (!empty($player['country'])): ?>
                            <div class="card-info"><strong>Pays:</strong> <?= htmlspecialchars($player['country']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>Gestionnaire d'équipes et de joueurs - 2025</p>
    </footer>
</body>
</html>