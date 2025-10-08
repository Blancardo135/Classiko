<?php
require 'Database.php';
require 'Team.php';

class TeamsManager {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function getTeams() {
        // On définit la requête SQL pour récupérer tous les animaux
        $sql = "SELECT * FROM teams";

        // On prépare la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // On exécute la requête SQL
        $stmt->execute();

        // On récupère tous les animaux
        $teams = $stmt->fetchAll();

        // On transforme la chaîne `personalities` en tableau pour chaque animal
        // On retourne tous les animaux
        return $teams;
    }

    public function getTeam($id) {
        // On définit la requête SQL pour récupérer un animal
        $sql = "SELECT * FROM teams WHERE id = :id";

        // On prépare la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // On lie le paramètre
        $stmt->bindValue(':id', $id); //bindValue pour assigner une valeur à un paramètre dans une requete pour éviter attaque par injection

        // On exécute la requête SQL
        $stmt->execute();

        // On récupère le résultat comme tableau associatif
        $team = $stmt->fetch();
        return $team;
    }

    public function addTeam($team) {
        $id = $team['id'];
        $name = $team['name'];
        $nbPlayers = $team['nbPlayers'];
        $descr = $team['descr'];
        $sport = $team['sport'];

        // On définit la requête SQL pour ajouter une équipe
        $sql = "INSERT INTO teams (
            name,
            nbPlayers,
            descr,
            sport
        ) VALUES (
            :name,
            :nbPlayers,
            :descr,
            :sport
        )";

        // On prépare la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // On lie les paramètres
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers());
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());

        // On exécute la requête SQL pour ajouter un équipe
        $stmt->execute();

        // On récupère l'identifiant de l'équipe ajoutée
        $teamId = $this->database->getPdo()->lastInsertId();

        // On retourne l'identifiant de é'équipe ajoutée.
        return $teamId;
    }

    public function updateTeam($id, $team) {


        // On définit la requête SQL pour mettre à jour un animal
        $sql = "UPDATE teams SET
            name = :name,
            nbPlayers = :nbPlayers,
            descr = :descr,
            sport = :sport,
        WHERE id = :id";

        // On prépare la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // On lie les paramètres
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $team->getName());
        $stmt->bindValue(':nbPlayers', $team->getNbPlayers());
        $stmt->bindValue(':descr', $team->getDescr());
        $stmt->bindValue(':sport', $team->getSport());

        // On exécute la requête SQL pour mettre à jour un animal
        return $stmt->execute();
    }

    public function removeTeam($id) {
        // On définit la requête SQL pour supprimer un animal
        $sql = "DELETE FROM teams WHERE id = :id";

        // On prépare la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // On lie le paramètre
        $stmt->bindValue(':id', $id);

        // On exécute la requête SQL pour supprimer un animal
        return $stmt->execute();
    }
}