<?php
require_once __DIR__ . '/Database.php';

class PlayersManager
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getPdo();
    }

    // 🔹 Récupérer tous les joueurs
    public function getAllPlayers(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM players ORDER BY lastname ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Récupérer un joueur par ID
    public function getPlayerById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM players WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $player = $stmt->fetch(PDO::FETCH_ASSOC);
        return $player ?: null;
    }

    // 🔹 Ajouter un nouveau joueur
    public function addPlayer(string $firstname, string $lastname, ?string $country, ?string $club, ?string $position, ?int $team_id): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO players (firstname, lastname, country, club, position, team_id)
            VALUES (:firstname, :lastname, :country, :club, :position, :team_id)
        ");
        return $stmt->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'country' => $country,
            'club' => $club,
            'position' => $position,
            'team_id' => $team_id
        ]);
    }

    // 🔹 Modifier un joueur existant
    public function updatePlayer(int $id, string $firstname, string $lastname, ?string $country, ?string $club, ?string $position, ?int $team_id): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE players
            SET firstname = :firstname,
                lastname = :lastname,
                country = :country,
                club = :club,
                position = :position,
                team_id = :team_id
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'country' => $country,
            'club' => $club,
            'position' => $position,
            'team_id' => $team_id
        ]);
    }

    // 🔹 Supprimer un joueur
    public function deletePlayer(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM players WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}