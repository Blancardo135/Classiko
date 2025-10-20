<?php

class Database {

    const DATABASE_FILE = '../teamsmanager.db';

    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("sqlite:" . self::DATABASE_FILE);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->createTables();
    }

    private function createTables() {

        $sqlTeams = "CREATE TABLE IF NOT EXISTS teams (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            nbPlayers INTEGER NOT NULL,
            descr TEXT,
            sport TEXT NOT NULL
        );";

        $sqlPlayers = "CREATE TABLE IF NOT EXISTS players (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            firstname TEXT NOT NULL,
            lastname TEXT NOT NULL,
            country TEXT,
            club TEXT,
            position TEXT,
            team_id INTEGER,
            FOREIGN KEY (team_id) REFERENCES teams(id)
        );";

        $this->pdo->exec($sqlTeams);
        $this->pdo->exec($sqlPlayers);
    }

    public function getPdo() {
        return $this->pdo;
    }
}