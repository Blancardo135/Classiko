<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
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
        $this->createTables();
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    private function createTables(): void {
        $sqlTeams = "CREATE TABLE IF NOT EXISTS teams (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            nbPlayers INT NOT NULL,
            descr TEXT,
            sport VARCHAR(100) NOT NULL
        );";

        $this->pdo->exec($sqlTeams);
    }
}