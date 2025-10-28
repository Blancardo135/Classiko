<?php
// Inclut l'autoloader pour charger automatiquement les classes
require_once __DIR__ . '/../../src/utils/autoloader.php';

// Importe les classes nécessaires avec des namespaces
use Team\TeamsManager;
use Team\Team;

// Création d'une instance du gestionnaire d'équipes
$teamsManager = new TeamsManager();

// Gestion de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $name = $_POST["name"];
    $nbPlayers = $_POST["nbPlayers"];
    $descr = $_POST["descr"];
    $sport = $_POST["sport"];

    $errors = [];

    try {
        // Création d'un objet Team avec les données saisies
        $team = new Team(
            null, // id = null pour l'insertion
            $name,
            (int)$nbPlayers,
            $descr,
            $sport
        );
    } catch (InvalidArgumentException $e) {
        // Gère les erreurs de validation (ex: nombre négatif, champ vide)
        $errors[] = $e->getMessage();
    }

    // Si aucune erreur, tentative d'insertion en base de données
    if (empty($errors)) {
        try {
            $teamId = $teamsManager->addTeam($team); // Méthode du manager pour insérer

            // Redirection vers la page d'accueil (ou autre)
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            // Erreur SQL (doublons, contraintes, etc.)
            if ($e->getCode() === "23000") {
                $errors[] = "Une équipe avec ce nom existe déjà.";
            } else {
                $errors[] = "Erreur lors de la base de données : " . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = "Erreur inattendue : " . $e->getMessage();
        }
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
    <link rel="stylesheet" href="../css/custom.css">
    <title>Créer une équipe | MonApp</title>
</head>

<body>
    <main class="container">
        <h1>Créer une nouvelle équipe</h1>

        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des équipes</a> > Création d'une équipe</p>

        <!-- Affichage des messages de validation ou d'erreur -->
        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">L’équipe a été créée avec succès !</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <!-- Formulaire de création d'une équipe -->
        <form action="createTeam.php" method="POST">
            <label for="name">Nom de l’équipe</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? ''); ?>" required minlength="2">

            <label for="nbPlayers">Nombre de joueurs</label>
            <input type="number" id="nbPlayers" name="nbPlayers" value="<?= htmlspecialchars($nbPlayers ?? ''); ?>" required min="1">

            <label for="descr">Description</label>
            <textarea id="descr" name="descr" rows="3"><?= htmlspecialchars($descr ?? ''); ?></textarea>

            <label for="sport">Sport</label>
            <input type="text" id="sport" name="sport" value="<?= htmlspecialchars($sport ?? ''); ?>" required>

            <button type="submit">Créer l’équipe</button>
        </form>
    </main>
</body>

</html>