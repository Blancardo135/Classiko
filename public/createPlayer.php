<?php
//Page qui permet de créer son équipe
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php';
$playersManager = new PlayersManager();

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $name= $_POST["name"];
    $surname= $_POST["surname"];
    $country= $_POST["country"];
    $club= $_POST["club"];
    $position= $_POST["position"];


$player = new Player (
    $name,
    $surname,
    $country,
    $club,
    $position
);

$errors = $player->validate();
if(empty($errors)){
    $playerId = $playersManager->addPlayer($player);
    header("Location: index.php");
    exit();
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Crée un nouveau joueur</title>

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
    <h1>Ajoutes un joueur</h1>
    <p><a href="index.php">Retour à l'accueil</a></p>
    <p>Utilise cette page pour créer tes joueurs favoris.</p>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
        <?php if (empty($errors)) { ?>
            <p style="color: green;">Le joueur à été créée avec succès.'</p>
        <?php } else { ?>
            <p style="color: red;">Oups, il y a quelque chose qui ne va pas :</p>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
    <?php } ?>

    <form action="createPlayer.php" method ="POST">
        
        <label for="name">Prénom :</label><br>
        <input type="text" id="name" name="name" value="<?php if (isset($name)) echo htmlspecialchars($name); ?>" minlength="2" maxlength="40">

        <br>

        <label for="surname">Nom :</label><br>
        <input type="text" id="surname" name="surname" value="<?php if (isset($surname)) echo htmlspecialchars($surname); ?>" required minlength="2" maxlength="40">

        <br>

        <label for="country">Pays :</label><br>
        <input type="text" id="country" name="country" value="<?php if (isset($country)) echo htmlspecialchars($country); ?>" minlength="2" maxlength="40">

        <br>

        <label for="club">Club :</label><br>
        <input type="text" id="club" name="club" value="<?php if (isset($club)) echo htmlspecialchars($club); ?>" required minlength="2" maxlength="100">

        <br>

        <label for="position">Position :</label><br>
        <input type="text" id="position" name="position" value="<?php if (isset($position)) echo htmlspecialchars($position); ?>" required>

        <br>

        <button type="submit">Créer</button><br>
        <button type="reset">Réinitialiser</button>
    </form>

</body>
</html>