<?php
require_once __DIR__ . '/Team.php';
require_once __DIR__ . '/Database.php';

class TeamsManager
{
    private $pdo;

    public function __construct()
    {
        // On se connecte à la base SQLite via la classe Database
        $db = new Database();
        $this->pdo = $db->getPdo();
    }

    public function addTeam(Team $team)
    {
        $sql = "INSERT INTO teams (name, nbPlayers, descr, sport) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $team->getName(),
            $team->getNbPlayers(),
            $team->getDescr(),
            $team->getSport()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getAllTeams()
    {
        $stmt = $this->pdo->query("SELECT * FROM teams");
        $teams = [];

        while ($row = $stmt->fetch()) {
            $teams[] = new Team($row['name'], $row['nbPlayers'], $row['descr'], $row['sport']);
        }

        return $teams;
    }

    public function getTeamById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Team($row['name'], $row['nbPlayers'], $row['descr'], $row['sport']);
        }

        return null;
    }
}