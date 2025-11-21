<?php


function requireLogin(): int
{
    session_start();
    $currentUserId = $_SESSION['user_id'] ?? null;

    if ($currentUserId === null) {
        header('Location: ../auth/login.php');
        exit();
    }

    return (int)$currentUserId;
}

function requireOwnership(string $table, int $resourceId, int $currentUserId): void
{
    $pdo = \Database::getInstance()->getPdo();
    $stmt = $pdo->prepare("SELECT owner_user_id FROM $table WHERE id = :id");
    $stmt->bindValue(':id', $resourceId, \PDO::PARAM_INT);
    $stmt->execute();
    $owner = $stmt->fetchColumn();

    if ($owner !== false && (int)$owner !== (int)$currentUserId) {
        header('Location: ../403.php');
        exit();
    }
}
