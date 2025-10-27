<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Team.php';

class TeamsManager
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getTeams()
    {
        $sql = "SELECT * FROM teams";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeam($id)
    {
        $sql = "SELECT * FROM teams WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}