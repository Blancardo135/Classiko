<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Accueil | Gestion des équipes</title>
</head>

<body>
    <main class="container">
        <h1>Gestion des équipes</h1>

        <p>Bienvenue dans l'application de gestion d’équipes.</p>

        <p><a href="team/index.php"><button>Voir les équipes</button></a></p>
        <p><a href="player/index.php"><button>Voir les joueurs</button></a></p>

        <!-- cookie langue -->
        <hr>
        <form method="get" style="margin-top: 1em;">
            <label for="lang">Choisissez votre langue :</label>
            <select name="lang" id="lang" onchange="this.form.submit()">
                <option value="fr" selected>Français</option>
                <option value="en">English</option>
            </select>
        </form>

        <p style="font-size: 0.9em; color: gray;">Langue actuelle : FR</p>
        <!-- cookie langue -->
    </main>
</body>
</html>
