<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Player\Player;
use Team\TeamsManager;

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();
$teams = $teamsManager->getTeams();

if (isset($_GET["id"])) {
    // Récupération de l'ID de l'outil de la superglobale `$_GET`
    $playerId = $_GET["id"];

    // Suppression de l'outil correspondant à l'ID
    $playersManager->removePlayer($playerId);

    header("Location: index.php");
    exit();
} else {
    // Si l'ID n'est pas passé dans l'URL, redirection vers la page d'accueil
    header("Location: index.php");
    exit();
}