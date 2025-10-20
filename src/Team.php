<?php

class Team {

    private $name;
    private $nbPlayers;
    private $descr;
    private $sport;

    public function __construct(
        $name,
        $nbPlayers,
        $descr,
        $sport,
    ) {
        $this->name = $name;
        $this->nbPlayers = $nbPlayers;
        $this->descr = $descr;
        $this->sport = $sport;
    }

    public function validate() {
        $errors = [];

        if (empty($this->name)) {
            array_push($errors, "Le nom est obligatoire.");
        }

        if (strlen($this->name) < 2) {
            array_push($errors, "Le nom doit contenir au moins 2 caractères.");
        }

        if (empty($this->nbPlayers)) {
            array_push($errors, "La taille de l'effectif est obligatoire.");
        }

        if ($this->nbPlayers > 11 || $this->nbPlayers < 2) {
            array_push($errors, "La taille de l'effectif doit être comprise entre 2 et 11.");
        }

        if (empty($this->sport)) {
            array_push($errors, "Le nom du sport est obligatoire.");
        }

        return $errors;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getNbPlayers() {
        return $this->nbPlayers;
    }

    public function setNbPlayers($nbPlayers) {
        $this->nbPlayers = $nbPlayers;
    }

    public function getDescr() {
        return $this->descr;
    }

    public function setDescr($descr) {
        $this->descr = $descr;
    }

    public function getSport() {
        return $this->sport;
    }

    public function setSport($sport) {
        $this->sport = $sport;
    }
}