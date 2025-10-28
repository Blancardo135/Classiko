<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Teams\TeamsManager;

// Création d'une instance de TeamsManager
$teamsManager = new TeamsManager();

// Vérifie si un identifiant d'équipe a été fourni via l'URL (GET)
if (isset($_GET["id"])) {
    // Récupération de l'ID de l'équipe
    $teamId = $_GET["id"];

    // Suppression de l'équipe via le manager
    $teamsManager->removeTeam($teamId);

    // Redirection vers la page principale (liste des équipes)
    header("Location: index.php");
    exit();
} else {
    // Aucun ID fourni --> redirection vers la liste des équipes
    header("Location: index.php");
    exit();
}