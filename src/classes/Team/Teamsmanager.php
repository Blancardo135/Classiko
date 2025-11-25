<?php

namespace Team;

use Database;

class TeamsManager implements TeamsManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();  // Change juste cette ligne
    }

    /**
     * Récupère toutes les équipes
     * @return Team[]
     */
    public function getTeams(?int $ownerUserId = null): array
    {
        // If an owner user id is provided, return only teams owned by that user using INNER JOIN
        if ($ownerUserId !== null) {
            $sql = "SELECT t.* FROM teams t INNER JOIN users u ON t.owner_user_id = u.id WHERE u.id = :uid";
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->bindValue(':uid', $ownerUserId, \PDO::PARAM_INT);
            $stmt->execute();
            $teams = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT t.* FROM teams t";
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->execute();
            $teams = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

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

    public function addTeam(Team $team, ?int $ownerUserId = null): int
    {
        $sql = "INSERT INTO teams (name, nbPlayers, descr, sport, owner_user_id)
                VALUES (:name, :nbPlayers, :descr, :sport, :owner_user_id)";

        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers(), \PDO::PARAM_INT);
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());
        if ($ownerUserId === null) {
            $stmt->bindValue(':owner_user_id', null, \PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':owner_user_id', $ownerUserId, \PDO::PARAM_INT);
        }

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

    public function getAllTeamsWithOwner(): array
    {
        $sql = "SELECT t.*, u.firstname as owner_firstname, u.lastname as owner_lastname, u.email as owner_email 
                FROM teams t 
                LEFT JOIN users u ON t.owner_user_id = u.id 
                ORDER BY t.id DESC";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}