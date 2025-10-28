<?php

namespace Team;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;

class TeamsManager implements TeamsManagerInterface{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * Récupère toutes les équipes
     * @return Team[]
     */
    public function getTeams(): array
    {
        $sql = "SELECT * FROM teams";

        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();

        $teams = $stmt->fetchAll();

        $teams = array_map(function ($teamData) {
            return new Team(
                (int)$teamData['id'],
                $teamData['name'],
                (int)$teamData['nbPlayers'],
                $teamData['descr'],
                $teamData['sport']
            );
        }, $teams);

        return $teams;
    }

    
    public function getTeamById(int $id): ?Team
    {
        $sql = "SELECT * FROM teams WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $teamData = $stmt->fetch();

        if ($teamData) {
            return new Team(
                (int)$teamData['id'],
                $teamData['name'],
                (int)$teamData['nbPlayers'],
                $teamData['descr'],
                $teamData['sport']
            );
        }

        return null;
    }

   
    public function addTeam(Team $team): int
    {
        $sql = "INSERT INTO teams (name, nbPlayers, descr, sport)
                VALUES (:name, :nbPlayers, :descr, :sport)";

        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers(), \PDO::PARAM_INT);
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());

        $stmt->execute();

        return (int)$this->database->getPdo()->lastInsertId();
    }

    
    public function updateTeam(Team $team): bool
    {
        $sql = "UPDATE teams 
                SET name = :name,
                    nbPlayers = :nbPlayers,
                    descr = :descr,
                    sport = :sport
                WHERE id = :id";

        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers(), \PDO::PARAM_INT);
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());
        $stmt->bindValue(':id', $team->getId(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    
    public function removeTeam(int $id): bool
    {
        $sql = "DELETE FROM teams WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}