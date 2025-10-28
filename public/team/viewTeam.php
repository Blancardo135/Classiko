<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Managers\TeamsManager;

// Création d’une instance de TeamsManager
$teamsManager = new TeamsManager();

// Vérifie que l’ID de l’équipe est présent dans l’URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$teamId = (int) $_GET['id'];

// Recherche l’équipe par son ID
$team = $teamsManager->getTeamById($teamId);

// Si l’équipe n’est pas trouvée, redirection
if (!$team) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Équipe : <?= htmlspecialchars($team->getName()) ?></title>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.5.10/css/pico.min.css">
</head>
<body class="container">
    <main>
        <h1>Détails de l’équipe</h1>

        <article>
            <h2><?= htmlspecialchars($team->getName()) ?></h2>
            <p><strong>Sport :</strong> <?= htmlspecialchars($team->getSport()) ?></p>
            <p><strong>Nombre de joueurs :</strong> <?= $team->getNbPlayers() ?></p>
            <p><strong>Description :</strong></p>
            <p><?= nl2br(htmlspecialchars($team->getDescr())) ?></p>
        </article>

        <p>
            <a href="index.php" role="button">Retour à l’accueil</a>
            <a href="editTeam.php?id=<?= $team->getId() ?>" role="button">Modifier</a>
        </p>
    </main>
</body>
</html>