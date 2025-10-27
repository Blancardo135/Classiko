<?php
require_once __DIR__ . '/../src/TeamsManager.php';

$manager = new TeamsManager();
$teams = $manager->getAllTeams();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestionnaire d'équipes</title>
    <link rel="stylesheet" href="style.css"> <!-- si tu en as un -->
</head>
<body>
    <h1>⚽ Gestionnaire d'équipes et de joueurs</h1>

    <section>
        <h2>🏆 Mes équipes</h2>

        <a class="btn" href="createTeam.php">➕ Créer une nouvelle équipe</a>

        <?php if (empty($teams)): ?>
            <div class="empty">
                <p>Aucune équipe enregistrée pour le moment.</p>
            </div>
        <?php else: ?>
            <?php foreach ($teams as $team): ?>
                <div class="team-card">
                    <h3 style="color: green;"><?= htmlspecialchars($team->getName()) ?></h3>
                    <p><strong>Sport :</strong> <?= htmlspecialchars($team->getSport()) ?></p>
                    <p><strong>Nombre de joueurs :</strong> <?= htmlspecialchars($team->getNbPlayers()) ?></p>
                    <?php if (!empty($team->getDescr())): ?>
                        <p><strong>Description :</strong> <?= htmlspecialchars($team->getDescr()) ?></p>
                    <?php endif; ?>
                    <p>
                        <a href="editTeam.php?id=<?= $team->getId() ?>">✏️ Modifier</a> |
                        <a href="deleteTeam.php?id=<?= $team->getId() ?>" onclick="return confirm('Supprimer cette équipe ?')">🗑️ Supprimer</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <section>
        <h2>👥 Mes joueurs</h2>
        <div class="empty">
            <p>Aucun joueur enregistré.</p>
            <a class="btn" href="createPlayer.php">Ajouter un joueur</a>
        </div>
    </section>
</body>
</html>