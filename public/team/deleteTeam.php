<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
use Team\TeamsManager;
use Database;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireLogin();

// Création d'une instance de TeamsManager
$teamsManager = new TeamsManager();

// Vérifie si un identifiant d'équipe a été fourni via l'URL (GET)
if (isset($_GET["id"])) {
    // Récupération de l'ID de l'équipe
    $teamId = (int) $_GET["id"];

    // ownership check
    $pdo = Database::getInstance()->getPdo();
    $ownerStmt = $pdo->prepare('SELECT owner_user_id FROM teams WHERE id = :id');
    $ownerStmt->bindValue(':id', $teamId, \PDO::PARAM_INT);
    $ownerStmt->execute();
    $owner = $ownerStmt->fetchColumn();

    if ($owner !== false && ((int)$owner !== (int)$currentUserId)) {
        header('Location: ../403.php');
        exit();
    }

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