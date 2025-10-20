<?php
class Database {
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->pdo = new PDO("sqlite:" . __DIR__ . "/../teamsmanager.db");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}