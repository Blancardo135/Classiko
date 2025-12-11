<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
use Team\TeamsManager;
use Database;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireLogin();
$teamsManager = new TeamsManager();


if (isset($_GET["id"])) {
    
    $teamId = (int) $_GET["id"];

    
    $pdo = Database::getInstance()->getPdo();
    $ownerStmt = $pdo->prepare('SELECT owner_user_id FROM teams WHERE id = :id');
    $ownerStmt->bindValue(':id', $teamId, \PDO::PARAM_INT);
    $ownerStmt->execute();
    $owner = $ownerStmt->fetchColumn();

    if ($owner !== false && ((int)$owner !== (int)$currentUserId)) {
        header('Location: ../403.php');
        exit();
    }
    $teamsManager->removeTeam($teamId);

    
    header("Location: index.php");
    exit();
} else {
  
    header("Location: index.php");
    exit();
}