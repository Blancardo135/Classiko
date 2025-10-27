<?php

class Player
{
    private $id;
    private $name;
    private $surname;
    private $position;
    private $club;
    private $country;

    public function __construct($name, $surname, $position, $club, $country)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->position = $position;
        $this->club = $club;
        $this->country = $country;
    }

    // --- Getters ---
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getSurname() { return $this->surname; }
    public function getPosition() { return $this->position; }
    public function getClub() { return $this->club; }
    public function getCountry() { return $this->country; }

    // --- Setters ---
    public function setName($name) { $this->name = $name; }
    public function setSurname($surname) { $this->surname = $surname; }
    public function setPosition($position) { $this->position = $position; }
    public function setClub($club) { $this->club = $club; }
    public function setCountry($country) { $this->country = $country; }
}