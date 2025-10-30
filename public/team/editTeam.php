<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Team\TeamsManager;
use Team\Team;

// Création d'une instance de TeamsManager
$teamsManager = new TeamsManager();

// Récupération de l'équipe à modifier si l'ID est passé en GET
if (isset($_GET["id"])) {
    $teamId = $_GET["id"];
    $team = $teamsManager->getTeamById($teamId);

    if (!$team) {
        die("Équipe non trouvée.");
    }
} else {
    // Redirection si aucun ID
    header("Location: index.php");
    exit();
}

// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $name = $_POST["name"];
    $nbPlayers = $_POST["nbPlayers"];
    $descr = $_POST["descr"];
    $sport = $_POST["sport"];

    $errors = [];

    try {
        // Création d’un objet Team avec les nouvelles valeurs
        $updatedTeam = new Team(
            $teamId,
            $name,
            (int) $nbPlayers,
            $descr,
            $sport
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }

    // S’il n’y a pas d’erreurs, on met à jour
    if (empty($errors)) {
        try {
            $teamsManager->updateTeam($updatedTeam);

            // Redirection vers la page d’accueil
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $errors[] = "Ce nom d’équipe existe déjà.";
            } else {
                $errors[] = "Erreur base de données : " . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = "Erreur inattendue : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Modifier l’équipe | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Modifier l’équipe</h1>

        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des équipes</a> > Modification</p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">L’équipe a été modifiée avec succès.</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="editTeam.php?id=<?= htmlspecialchars($teamId) ?>" method="POST">
            <label for="name">Nom de l’équipe</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($team->getName() ?? '') ?>" required minlength="2">

            <label for="nbPlayers">Nombre de joueurs</label>
            <input type="number" id="nbPlayers" name="nbPlayers" value="<?= htmlspecialchars($team->getNbPlayers() ?? '') ?>" required min="1">

            <label for="descr">Description</label>
            <textarea id="descr" name="descr" required><?= htmlspecialchars($team->getDescr() ?? '') ?></textarea>

            <label for="sport">Sport</label>
            <input type="text" id="sport" name="sport" value="<?= htmlspecialchars($team->getSport() ?? '') ?>" required>

            <button type="submit">Modifier</button>
        </form>
    </main>
</body>

</html>