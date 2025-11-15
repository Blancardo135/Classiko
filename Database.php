<?php

require_once __DIR__ . '/DatabaseInterface.php';

class Database implements DatabaseInterface {

    const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../config/database.ini';

    private $pdo;

    public function __construct() {
        // Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
        $config = parse_ini_file(self::DATABASE_CONFIGURATION_FILE, true);

        if (!$config) {
            throw new Exception("Erreur lors de la lecture du fichier de configuration : " . self::DATABASE_CONFIGURATION_FILE);
        }

        $host = $config['b35v6r.myd.infomaniak.com'];
        $port = $config['3306'];
        $database = $config['b35v6r_classiko'];
        $username = $config['b35v6r_ropira'];
        $password = $config['Ropira113013'];

        // Documentation :
        //   - https://www.php.net/manual/fr/pdo.connections.php
        //   - https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
        $this->pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);

        // Création de la base de données si elle n'existe pas
        $sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Sélection de la base de données
        $sql = "USE `$database`;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Création de la table `tools` si elle n'existe pas
        $sqlTeams = "CREATE TABLE IF NOT EXISTS teams (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            nbPlayers INT NOT NULL,
            descr TEXT,
            sport VARCHAR(100) NOT NULL
        );";

        $sqlPlayers = "CREATE TABLE IF NOT EXISTS players (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            country VARCHAR(100),
            club VARCHAR(100),
            position VARCHAR(50),
            team_id INT,
            FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL
        );";

        $sqlUsers = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(100) NOT NULL,
            lastname VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";

        $this->pdo->exec($sqlTeams);
        $this->pdo->exec($sqlPlayers);
        $this->pdo->exec($sqlUsers);
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}

// // src/Database.php

// class Database
// {
//     private static ?Database $instance = null;
//     private PDO $pdo;

//     private function __construct()
//     {
//         $host = 'b35v6r.myd.infomaniak.com';
//         $port = 3306;
//         $db   = 'b35v6r_classiko';
//         $user = 'b35v6r_ropira';
//         $pass = 'Ropira113013.';
//         $charset = 'utf8mb4';

//         $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

//         $options = [
//             PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         ];

//         $this->pdo = new PDO($dsn, $user, $pass, $options);

//         // crée les tables si besoin
//         $this->createTables();
//     }

//     public static function getInstance(): Database
//     {
//         if (self::$instance === null) {
//             self::$instance = new Database();
//         }
//         return self::$instance;
//     }

//     public function getPdo(): PDO
//     {
//         return $this->pdo;
//     }

//     private function createTables(): void
//     {
//         $sqlTeams = "CREATE TABLE IF NOT EXISTS teams (
//             id INT AUTO_INCREMENT PRIMARY KEY,
//             name VARCHAR(100) NOT NULL,
//             nbPlayers INT NOT NULL,
//             descr TEXT,
//             sport VARCHAR(100) NOT NULL
//         ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

//         $sqlPlayers = "CREATE TABLE IF NOT EXISTS players (
//             id INT AUTO_INCREMENT PRIMARY KEY,
//             firstname VARCHAR(100) NOT NULL,
//             lastname VARCHAR(100) NOT NULL,
//             country VARCHAR(100),
//             club VARCHAR(100),
//             position VARCHAR(50),
//             team_id INT,
//             FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE SET NULL
//         ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

//         $this->pdo->exec($sqlTeams);
//         $this->pdo->exec($sqlPlayers);
//     }
// }