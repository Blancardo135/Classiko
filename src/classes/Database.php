<?php
require_once __DIR__ . '/DatabaseInterface.php';

class Database{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $host = 'b35v6r.myd.infomaniak.com';
        $port = 3306;
        $db   = 'b35v6r_classiko';
        $user = 'b35v6r_ropira';
        $pass = 'Ropira113013.';
        $charset = 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $options);

        // crée les tables si besoin
        $this->createTables();
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    private function createTables(): void
    {
        $sqlTeams = "CREATE TABLE IF NOT EXISTS teams (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            nbPlayers INT NOT NULL,
            descr TEXT,
            sport VARCHAR(100) NOT NULL,
            owner_user_id INT DEFAULT NULL,
            FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $sqlPlayers = "CREATE TABLE IF NOT EXISTS players (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            country VARCHAR(100),
            club VARCHAR(100),
            position VARCHAR(50),
            team_id INT,
            FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL,
            owner_user_id INT DEFAULT NULL,
            FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('user','admin') NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->pdo->exec($sqlTeams);
        $this->pdo->exec($sqlPlayers);
        $this->pdo->exec($sqlUsers);

        try {
            $this->pdo->exec("ALTER TABLE teams ADD COLUMN IF NOT EXISTS owner_user_id INT DEFAULT NULL;");
        } catch (\Throwable $e) {
            
        }
        try {
            $this->pdo->exec("ALTER TABLE players ADD COLUMN IF NOT EXISTS owner_user_id INT DEFAULT NULL;");
        } catch (\Throwable $e) {
            
        }
    }
}