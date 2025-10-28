<?php
// src/Player.php

class Player
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private ?string $country;
    private ?string $club;
    private string $position;
    private ?int $team_id;

    public function __construct(string $firstname, string $lastname, ?string $country, ?string $club, string $position, ?int $team_id, ?int $id = null)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->country = $country;
        $this->club = $club;
        $this->position = $position;
        $this->team_id = $team_id;
    }

    public function validate(): array
    {
        $errors = [];
        if (empty($this->firstname) || mb_strlen($this->firstname) < 1) $errors[] = "Le prénom est requis.";
        if (empty($this->lastname) || mb_strlen($this->lastname) < 1) $errors[] = "Le nom est requis.";
        if (empty($this->position)) $errors[] = "La position est requise.";
        if ($this->team_id === null || $this->team_id === 0) $errors[] = "Une équipe doit être sélectionnée.";
        return $errors;
    }

    // getters
    public function getId(): ?int { return $this->id; }
    public function getFirstname(): string { return $this->firstname; }
    public function getLastname(): string { return $this->lastname; }
    public function getCountry(): ?string { return $this->country; }
    public function getClub(): ?string { return $this->club; }
    public function getPosition(): string { return $this->position; }
    public function getTeamId(): ?int { return $this->team_id; }
}