<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Player.php';

class PlayersManager
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getPlayers()
    {
        $sql = "SELECT * FROM players";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlayer($id)
    {
        $sql = "SELECT * FROM players WHERE id = :id";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}