<?php
require_once __DIR__ . '/../src/TeamsManager.php';

$teamsManager = new TeamsManager();
$teamId = (int) ($_GET['id'] ?? 0);
$team = $teamsManager->getTeam($teamId);

if (!$team) {
    echo "Équipe non trouvée.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l’équipe</title>
</head>
<body>
    <h1>Détails de l’équipe : <?= htmlspecialchars($team->getName()) ?></h1>
    <a href="index.php">⬅️ Retour à la liste</a>

    <p><strong>Nombre de joueurs :</strong> <?= $team->getNbPlayers() ?></p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($team->getDescr())) ?></p>
    <p><strong>Sport :</strong> <?= htmlspecialchars($team->getSport()) ?></p>
</body>
</html>