<?php
// src/PlayersManager.php

namespace Player;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;

class PlayersManager implements PlayersManagerInterface {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function getPlayers(): array {
        // Définition de la requête SQL pour récupérer tous les outils
        $sql = "SELECT * FROM players";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les outils
        $players = $stmt->fetchAll();

        // Transformation des tableaux associatifs en objets Tool
        $players = array_map(function ($playerData) {
            return new Player(
                $playerData['id'],
                $playerData['firstname'],
                $playerData['lastname'],
                $playerData['country'],
                $playerData['club'],
                $playerData['position'],
                $playerData['team_id'],
            );
        }, $players);

        // Retour de tous les outils
        return $players;
    }

    public function addPlayer(Player $player): int {
        // Définition de la requête SQL pour ajouter un joueur
        $sql = "INSERT INTO players (firstname, lastname, country, club, position) VALUES (:firstname, :lastname, :country, :club, :position)";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec les paramètres
        $stmt->bindValue(':firstname', $player->getFirstName());
        $stmt->bindValue(':lastname', $player->getLastName());
        $stmt->bindValue(':country', $player->getCountry());
        $stmt->bindValue(':club', $player->getClub());
        $stmt->bindValue(':position', $player->getPosition());
        $stmt->bindValue(':team_id', $player->getTeamId());

        // Exécution de la requête SQL pour ajouter un outil
        $stmt->execute();

        // Récupération de l'identifiant de l'outil ajouté
        $playerId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant de l'outil ajouté.
        return $playerId;
    }

    public function removePlayer(int $id): bool {
        // Définition de la requête SQL pour supprimer un outil
        $sql = "DELETE FROM tools WHERE id = :id";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec le paramètre
        $stmt->bindValue(':id', $id);

        // Exécution de la requête SQL pour supprimer un outil
        return $stmt->execute();
    }
}

// require_once __DIR__ . '/Database.php';
// require_once __DIR__ . '/Player.php';

// class PlayersManager
// {
//     private PDO $pdo;

//     public function __construct()
//     {
//         $this->pdo = Database::getInstance()->getPdo();
//     }

//     public function addPlayer(Player $player): int
//     {
//         $stmt = $this->pdo->prepare("
//             INSERT INTO players (firstname, lastname, country, club, position, team_id)
//             VALUES (?, ?, ?, ?, ?, ?)
//         ");
//         $stmt->execute([
//             $player->getFirstname(),
//             $player->getLastname(),
//             $player->getCountry(),
//             $player->getClub(),
//             $player->getPosition(),
//             $player->getTeamId()
//         ]);
//         return (int)$this->pdo->lastInsertId();
//     }

//     public function getPlayer(int $id): ?Player
//     {
//         $stmt = $this->pdo->prepare("SELECT * FROM players WHERE id = ?");
//         $stmt->execute([$id]);
//         $row = $stmt->fetch(PDO::FETCH_ASSOC);
//         if ($row) {
//             return new Player($row['firstname'], $row['lastname'], $row['country'] ?? null, $row['club'] ?? null, $row['position'], isset($row['team_id']) ? (int)$row['team_id'] : null, (int)$row['id']);
//         }
//         return null;
//     }

//     public function updatePlayer(Player $player): bool
//     {
//         $stmt = $this->pdo->prepare("
//             UPDATE players SET firstname = ?, lastname = ?, country = ?, club = ?, position = ?, team_id = ? WHERE id = ?
//         ");
//         return $stmt->execute([
//             $player->getFirstname(),
//             $player->getLastname(),
//             $player->getCountry(),
//             $player->getClub(),
//             $player->getPosition(),
//             $player->getTeamId(),
//             $player->getId()
//         ]);
//     }

//     public function deletePlayer(int $id): bool
//     {
//         $stmt = $this->pdo->prepare("DELETE FROM players WHERE id = ?");
//         return $stmt->execute([$id]);
//     }

//     public function getAllPlayers(): array
//     {
//         $stmt = $this->pdo->query("SELECT * FROM players ORDER BY id DESC");
//         $players = [];
//         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//             $players[] = new Player($row['firstname'], $row['lastname'], $row['country'] ?? null, $row['club'] ?? null, $row['position'], isset($row['team_id']) ? (int)$row['team_id'] : null, (int)$row['id']);
//         }
//         return $players;
//     }
// }