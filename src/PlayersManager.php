<?php
// src/PlayersManager.php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Player.php';

class PlayersManager
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function addPlayer(Player $player): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO players (firstname, lastname, country, club, position, team_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $player->getFirstname(),
            $player->getLastname(),
            $player->getCountry(),
            $player->getClub(),
            $player->getPosition(),
            $player->getTeamId()
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function getPlayer(int $id): ?Player
    {
        $stmt = $this->pdo->prepare("SELECT * FROM players WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Player($row['firstname'], $row['lastname'], $row['country'] ?? null, $row['club'] ?? null, $row['position'], isset($row['team_id']) ? (int)$row['team_id'] : null, (int)$row['id']);
        }
        return null;
    }

    public function updatePlayer(Player $player): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE players SET firstname = ?, lastname = ?, country = ?, club = ?, position = ?, team_id = ? WHERE id = ?
        ");
        return $stmt->execute([
            $player->getFirstname(),
            $player->getLastname(),
            $player->getCountry(),
            $player->getClub(),
            $player->getPosition(),
            $player->getTeamId(),
            $player->getId()
        ]);
    }

    public function deletePlayer(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM players WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllPlayers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM players ORDER BY id DESC");
        $players = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $players[] = new Player($row['firstname'], $row['lastname'], $row['country'] ?? null, $row['club'] ?? null, $row['position'], isset($row['team_id']) ? (int)$row['team_id'] : null, (int)$row['id']);
        }
        return $players;
    }
}