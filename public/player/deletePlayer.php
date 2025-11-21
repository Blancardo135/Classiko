<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

use Player\PlayersManager;
use Team\TeamsManager;
use Database;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireLogin();

$playersManager = new PlayersManager();
$teamsManager = new TeamsManager();

if (isset($_GET["id"])) {
    $playerId = (int) $_GET["id"];

    // ownership check
    $pdo = Database::getInstance()->getPdo();
    $ownerStmt = $pdo->prepare('SELECT owner_user_id FROM players WHERE id = :id');
    $ownerStmt->bindValue(':id', $playerId, \PDO::PARAM_INT);
    $ownerStmt->execute();
    $owner = $ownerStmt->fetchColumn();

    if ($owner !== false && ($currentUserId === null || (int)$owner !== (int)$currentUserId)) {
        header('Location: ../403.php');
        exit();
    }

    // delete
    $playersManager->removePlayer($playerId);
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}