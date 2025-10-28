<?php
// src/TeamsManager.php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Team.php';

class TeamsManager
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function getAllTeams(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM teams ORDER BY id DESC");
        $teams = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $teams[] = new Team($row['name'], (int)$row['nbPlayers'], $row['descr'], $row['sport'], (int)$row['id']);
        }
        return $teams;
    }

    public function getTeam(int $id): ?Team
    {
        $stmt = $this->pdo->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Team($row['name'], (int)$row['nbPlayers'], $row['descr'], $row['sport'], (int)$row['id']);
        }
        return null;
    }

    public function addTeam(Team $team): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO teams (name, nbPlayers, descr, sport) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $team->getName(),
            $team->getNbPlayers(),
            $team->getDescr(),
            $team->getSport()
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateTeam(int $id, Team $team): bool
    {
        $stmt = $this->pdo->prepare("UPDATE teams SET name = ?, nbPlayers = ?, descr = ?, sport = ? WHERE id = ?");
        return $stmt->execute([
            $team->getName(),
            $team->getNbPlayers(),
            $team->getDescr(),
            $team->getSport(),
            $id
        ]);
    }

    public function deleteTeam(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM teams WHERE id = ?");
        return $stmt->execute([$id]);
    }
}