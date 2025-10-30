<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

$errors = [];

// Vérifie que l'ID du joueur est passé en paramètre
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID du joueur invalide.");
}

$playerId = (int) $_GET['id'];
$player = $playersManager->getPlayerById($playerId);

if (!$player) {
    die("Joueur non trouvé.");
}

// Pré-remplit les champs avec les données existantes
$firstname = $player->getFirstname();
$lastname = $player->getLastname();
$country = $player->getCountry();
$club = $player->getClub();
$position = $player->getPosition();
$team_id = $player->getTeamId();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $country = trim($_POST['country']);
    $club = trim($_POST['club']);
    $position = trim($_POST['position']);
    $team_id = $_POST['team_id'];

    try {
        // Crée un nouvel objet joueur avec les nouvelles valeurs
        $updatedPlayer = new Player(
            $playerId,           
            $firstname,
            $lastname,
            $country,
            $club,
            $position,
            (int)$team_id       
        );
        $updatedPlayer->setId($playerId); // garde l’ID existant

        // Met à jour le joueur dans la base
        $playersManager->updatePlayer($updatedPlayer);

        header("Location: index.php");
        exit;
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    } catch (PDOException $e) {
        $errors[] = "Erreur base de données : " . $e->getMessage();
    } catch (Exception $e) {
        $errors[] = "Erreur inattendue : " . $e->getMessage();
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
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title>Modifier un joueur | MyApp</title>
</head>

<body>
    <main class="container">
        <h1>Modifier un joueur</h1>
        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des joueurs</a> > Modifier un joueur</p>

        <?php if (!empty($errors)): ?>
            <article style="color: red;">
                <p>Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endif; ?>

        <form action="editPlayer.php?id=<?= $playerId ?>" method="POST">
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>" required minlength="2">

            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>" required minlength="2">

            <label for="country">Pays :</label>
            <input type="text" id="country" name="country" value="<?= htmlspecialchars($country) ?>" required minlength="2">

            <label for="club">Club :</label>
            <input type="text" id="club" name="club" value="<?= htmlspecialchars($club) ?>" required minlength="2">

            <label for="position">Position :</label>
            <input type="text" id="position" name="position" value="<?= htmlspecialchars($position) ?>" required minlength="2">

            <label for="team_id">Équipe :</label>
            <select id="team_id" name="team_id" required>
                <option value="">-- Sélectionner --</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team->getId(); ?>" <?= ($team_id == $team->getId()) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($team->getName()); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </main>
</body>

</html>