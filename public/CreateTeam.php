<?php
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php';
require_once __DIR__ . '/../src/Team.php';

$teamsManager = new TeamsManager();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $nbPlayers = $_POST["nbPlayers"];
    $descr = $_POST["descr"];
    $sport = $_POST["sport"];

    $team = new Team($name, $nbPlayers, $descr, $sport);

    $errors = $team->validate();

    if (empty($errors)) {
        $teamId = $teamsManager->addTeam($team);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Créer une nouvelle équipe</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; background-color: #f9f9f9; padding: 20px; }
        form { background: white; max-width: 600px; margin: auto; padding: 20px; border-radius: 8px; border: 1px solid #ccc; }
        button { background: #5cb85c; color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; }
        button:hover { background: #4cae4c; }
    </style>
</head>
<body>
    <h1>Créer une équipe</h1>
    <p><a href="index.php">Retour à l'accueil</a></p>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <?php if (empty($errors)) { ?>
            <p style="color:green;">Équipe créée avec succès !</p>
        <?php } else { ?>
            <ul style="color:red;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php } ?>
    <?php } ?>

    <form action="createTeam.php" method="POST">
        <label for="name">Nom de l'équipe :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required minlength="2" maxlength="100">

        <label for="nbPlayers">Nombre de joueurs :</label>
        <input type="number" id="nbPlayers" name="nbPlayers" value="<?= htmlspecialchars($nbPlayers ?? '') ?>" required min="2" max="11">

        <label for="descr">Description :</label>
        <textarea id="descr" name="descr" rows="4"><?= htmlspecialchars($descr ?? '') ?></textarea>

        <label for="sport">Sport :</label>
        <input type="text" id="sport" name="sport" value="<?= htmlspecialchars($sport ?? '') ?>" required>

        <button type="submit">Créer</button>
    </form>
</body>
</html>
