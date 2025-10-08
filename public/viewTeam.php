<?php
require '../src/TeamsManager.php';

$teamsManager = new TeamsManager();

// On vérifie si l'ID de l'animal est passé dans l'URL
if (isset($_GET["id"])) {
    // On récupère l'ID de l'animal de la superglobale `$_GET`
    $teamId = $_GET["id"];

    // On récupère l'animal correspondant à l'ID
    $team = $teamsManager->getTeam($teamId);

    // Si l'animal n'existe pas, on redirige vers la page d'accueil
    if (!$team) {
        header("Location: index.php");
        exit();
    }
} else {
    // Si l'ID n'est pas passé dans l'URL, on redirige vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Visualise tes équipes favorites | Gestionnaire d'équipes de sport</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        p {
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="color"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }

        input[type="radio"]+label,
        input[type="checkbox"]+label {
            display: inline-block;
            margin-right: 15px;
        }

        fieldset div {
            display: inline-block;
            margin-right: 10px;
        }

        fieldset {
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        legend {
            font-weight: bold;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        a {
            color: #5cb85c;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Visualise une tes équipes favorites</h1>
    <p><a href="index.php">Retour à l'accueil</a></p>
    <p>Utilise cette page pour visualiser tes équipes.</p>

    <form action="createPlayer.php" method ="POST">
        
        <label for="name">Nom de l'équipe :</label><br>
        <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>" minlength="2" maxlength="100">

        <br>

        <label for="surname">Nom :</label><br>
        <input type="text" id="surname" name="surname" value="<?php if (isset($surname)) echo htmlspecialchars($surname); ?>" required minlength="2" maxlength="40">

        <br>

        <label for="descr">Description :</label><br>
       <textarea name="descr" id="descr" rows ="4" cols="50" ><?php if (isset($descr)) echo htmlspecialchars($descr); ?> </textarea>

        <br>

        <label for="club">Club :</label><br>
        <input type="text" id="club" name="club" value="<?php if (isset($club)) echo htmlspecialchars($club); ?>" required minlength="2" maxlength="100">

        <br>

        <label for="sport">Type de sport :</label><br>
        <input type="text" id="sport" name="sport" value="<?php if (isset($sport)) echo htmlspecialchars($sport); ?>" required>

        <br>

         <a href="delete.php?id=<?= htmlspecialchars($pet["id"]) ?>">
            <button type="button">Supprimer</button>
        </a><br>
        <button type="submit">Mettre à jour</button><br>
        <button type="reset">Réinitialiser</button>
    </form>
</body>

</html>