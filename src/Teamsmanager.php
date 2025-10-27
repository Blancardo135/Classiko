<?php
require_once __DIR__ . '/Team.php';
require_once __DIR__ . '/Database.php';

class TeamsManager
{
    private $pdo;

    public function __construct()
    {
<<<<<<< HEAD
        // On se connecte à la base SQLite via la classe Database
        $db = new Database();
        $this->pdo = $db->getPdo();
=======
        $host = 'b35v6r.myd.infomaniak.com';
        $port = 3306;
        $db   = 'b35v6r_classiko';
        $user = 'b35v6r_ropira';
        $pass = 'Ropira113013.';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);
>>>>>>> 2d6fbae8cc5a14b4f83c4ae34c5cac5cb01e168f
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