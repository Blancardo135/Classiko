<?php
require_once __DIR__ . '/Team.php';

class TeamsManager {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $db   = 'classiko_db';
        $user = 'b35v6r_ropira';
        $pass = 'Ropira113013.';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    public function addTeam(Team $team) {
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

    public function getAllTeams() {
        $stmt = $this->pdo->query("SELECT * FROM teams");
        $teams = [];

        while ($row = $stmt->fetch()) {
            $teams[] = new Team($row['name'], $row['nbPlayers'], $row['descr'], $row['sport']);
        }

        return $teams;
    }
}