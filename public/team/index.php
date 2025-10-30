<?php
// Inclusion de l'autoloader pour charger automatiquement les classes
require_once __DIR__ . '/../../src/utils/autoloader.php';

// Inclusion explicite des classes nécessaires (optionnelle si l'autoloader est bien configuré)


use Team\TeamsManager;
use Team\Team;

// Instanciation du gestionnaire d'équipes
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams(); // Récupération de toutes les équipes
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">

    <title>Gestion des équipes | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Gestion des équipes</h1>

        <p><a href="../index.php">Accueil</a> > Gestion des équipes</p>

        <h2>Liste des équipes</h2>

        <p><a href="create.php"><button>Créer une nouvelle équipe</button></a></p>

        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Pays</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teams as $team) { ?>
                    <tr>
                        <td><?= htmlspecialchars($team->getName()) ?></td>
                        <td><?= htmlspecialchars($team->getSport()) ?></td>
                        <td>
                            <a href="edit.php?id=<?= htmlspecialchars($team->getId()) ?>"><button>Modifier</button></a>
                            <a href="delete.php?id=<?= htmlspecialchars($team->getId()) ?>"><button>Supprimer</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>