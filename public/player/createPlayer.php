<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

$errors = [];
$firstname = $lastname = $country = $club = $position = $team_id = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $country = $_POST['country'];
    $club = $_POST['club'];
    $position = $_POST['position'];
    $team_id = $_POST['team_id'];
    
    try {
        $player = new Player(
            null,
            $firstname,
            $lastname,
            $country,
            $club,
            $position,
            (int)$team_id

        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }
    if (empty($errors)) {
        try {
            $playerId = $playersManager->addPlayer($player);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {

            if ($e->getCode() === "23000") {
                $errors[] = "L'outil existe déjà.";
            } else {
                $errors[] = "Erreur lors de l'interaction avec la base de données : " . $e->getMessage();
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

    <title>Créer un nouveau joueur | MyApp</title>
</head>


<body>
    <main class="container">
        <h1>Créer un nouveau joueur</h1>

        <p><a href="../index.php">Accueil</a> > <a href="index.php">Gestion des joueurs</a> > Création d'un nouveau joueur</p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">Le formulaire a été soumis avec succès !</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="createPlayer.php" method="POST">
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname); ?>" required minlength="2">
            <br>

            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname); ?>" required minlength="2">
            <br>

            <label for="country">Pays :</label>
            <input type="text" id="country" name="country" value="<?= htmlspecialchars($country); ?>" required minlength="2">
            <br>

            <label for="club">Club :</label>
            <input type="text" id="club" name="club" value="<?= htmlspecialchars($club); ?>" required minlength="2">
            <br>

            <label for="position">Position :</label>
            <input type="text" id="position" name="position" value="<?= htmlspecialchars($position); ?>" required minlength="2">
            <br>

            <label for="team_id">Équipe :
                <select id="team_id" name="team_id" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?= $team->getId(); ?>"><?= htmlspecialchars($team->getName()); ?></option>
                    <?php endforeach; ?>
                </select>
            </label><br>

            <button type="submit">Créer</button>
        </form>
    </main>
</body>

</html>