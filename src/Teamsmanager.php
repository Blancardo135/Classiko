<?php
require_once __DIR__ . '/Team.php';

class TeamsManager {
    private $pdo;

    public function __construct() {
        // 🔧 Configuration pour Infomaniak
        $host = '127.0.0.1'; // ← crucial : ne pas utiliser 'localhost'
        $db   = 'classiko_db'; // ← nom de ta base
        $user = 'b35v6r_ropira'; // ← utilisateur
        $pass = 'Ropira113013.'; // ← mot de passe
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