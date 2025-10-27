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

    public function addTeam($team)
    {
        $sql = "INSERT INTO teams (name, nbPlayers, descr, sport)
                VALUES (:name, :nbPlayers, :descr, :sport)";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers());
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());
        $stmt->execute();
        return $this->database->getPdo()->lastInsertId();
    }

    public function updateTeam($id, $team)
    {
        $sql = "UPDATE teams SET
                    name = :name,
                    nbPlayers = :nbPlayers,
                    descr = :descr,
                    sport = :sport
                WHERE id = :id"; 
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers());
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());
        return $stmt->execute();
    }

    public function removeTeam($id)
    {
        $sql = "DELETE FROM teams WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}