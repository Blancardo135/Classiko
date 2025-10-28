<?php
// src/Team.php

class Team
{
    private ?int $id;
    private string $name;
    private int $nbPlayers;
    private ?string $descr;
    private string $sport;

    public function __construct(string $name, int $nbPlayers, ?string $descr, string $sport, ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nbPlayers = $nbPlayers;
        $this->descr = $descr;
        $this->sport = $sport;
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->name) || mb_strlen($this->name) < 2) {
            $errors[] = "Le nom de l’équipe doit contenir au moins 2 caractères.";
        }

        if (!is_numeric($this->nbPlayers) || $this->nbPlayers < 1 || $this->nbPlayers > 100) {
            $errors[] = "Le nombre de joueurs doit être un nombre valide (1-100).";
        }

        if (empty($this->sport)) {
            $errors[] = "Le type de sport est requis.";
        }

        return $errors;
    }

    // getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getNbPlayers(): int { return $this->nbPlayers; }
    public function getDescr(): ?string { return $this->descr; }
    public function getSport(): string { return $this->sport; }

    // setters si besoin
    public function setId(int $id): void { $this->id = $id; }
}