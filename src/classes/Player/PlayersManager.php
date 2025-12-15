<?php

namespace Player;

use Database;

class PlayersManager implements PlayersManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function getPlayers(?int $ownerUserId = null): array {

        if ($ownerUserId !== null) {
            $sql = "SELECT p.* FROM players p INNER JOIN users u ON p.owner_user_id = u.id WHERE u.id = :uid";
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->bindValue(':uid', $ownerUserId, \PDO::PARAM_INT);
            $stmt->execute();
            $playersData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            
            $sql = "SELECT * FROM players";
            
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->execute();
            
            $playersData = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }


        $players = array_map(function ($playerData) {
            return new Player(
                (int)$playerData['id'],
                $playerData['firstname'],
                $playerData['lastname'],
                $playerData['country'],
                $playerData['club'],
                $playerData['position'],
                (int)$playerData['team_id']
            );
        }, $playersData);

        return $players;
    }
    public function getPlayerById(int $id): ?Player {
        $sql = "SELECT * FROM players WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $playerData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($playerData) {
            return new Player(
                (int)$playerData['id'],
                $playerData['firstname'],
                $playerData['lastname'],
                $playerData['country'],
                $playerData['club'],
                $playerData['position'],
                (int)$playerData['team_id']
            );
        }

        return null;
    }

    public function updatePlayer(Player $player): bool {
        $sql = "UPDATE players 
                SET firstname = :firstname,
                    lastname = :lastname,
                    country = :country,
                    club = :club,
                    position = :position,
                    team_id = :team_id
                WHERE id = :id";

        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':firstname', $player->getFirstName());
        $stmt->bindValue(':lastname', $player->getLastName());
        $stmt->bindValue(':country', $player->getCountry());
        $stmt->bindValue(':club', $player->getClub());
        $stmt->bindValue(':position', $player->getPosition());
        $stmt->bindValue(':team_id', $player->getTeamId(), \PDO::PARAM_INT);
        $stmt->bindValue(':id', $player->getId(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function addPlayer(Player $player, ?int $ownerUserId = null): int {
        $sql = "INSERT INTO players (firstname, lastname, country, club, position, team_id, owner_user_id)
                VALUES (:firstname, :lastname, :country, :club, :position, :team_id, :owner_user_id)";
        
        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':firstname', $player->getFirstName());
        $stmt->bindValue(':lastname', $player->getLastName());
        $stmt->bindValue(':country', $player->getCountry());
        $stmt->bindValue(':club', $player->getClub());
        $stmt->bindValue(':position', $player->getPosition());
        $stmt->bindValue(':team_id', $player->getTeamId(), \PDO::PARAM_INT);
        if ($ownerUserId === null) {
            $stmt->bindValue(':owner_user_id', null, \PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':owner_user_id', $ownerUserId, \PDO::PARAM_INT);
        }

        $stmt->execute();

        return (int)$this->database->getPdo()->lastInsertId();
    }

    public function removePlayer(int $id): bool {
        $sql = "DELETE FROM players WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllPlayersWithOwner(): array {
        $sql = "SELECT p.*, u.firstname as owner_firstname, u.lastname as owner_lastname, u.email as owner_email 
                FROM players p 
                LEFT JOIN users u ON p.owner_user_id = u.id 
                ORDER BY p.id DESC";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}