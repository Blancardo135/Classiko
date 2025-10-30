<?php

namespace Player;


class Player implements PlayerInterface {
    // Propriétés privées pour assurer l'encapsulation
    private ?int $id; //comme dans team, j'ai mis le "?" pour le rendre nullable
    private string $firstname;
    private string $lastname;
    private string $country;
    private string $club;
    private string $position;
    private int $team_id;

    // Constructeur pour initialiser l'objet
    public function __construct(?int $id, string $firstname, string $lastname, string $country, string $club, string $position, int $team_id) {
        // Vérification des données
        if (empty($firstname)) {
            throw new \InvalidArgumentException("Le prénom du joueur est requis.");
        } else if (strlen($firstname) < 2) {
            throw new \InvalidArgumentException("Le prénom du joueur doit contenir au moins 2 caractères.");
        }

        if (empty($lastname)) {
            throw new \InvalidArgumentException("Le nom du joueur est requis.");
        } else if (strlen($lastname) < 2) {
            throw new \InvalidArgumentException("Le nom du joueur doit contenir au moins 2 caractères.");
        }

        if (empty($country)) {
            throw new \InvalidArgumentException("Le pays est requis.");
        } elseif (strlen($country) < 2) {
            throw new \InvalidArgumentException("Le pays doit contenir au moins 2 caractères.");
        }

        if (empty($club)) {
            throw new \InvalidArgumentException("Le club est requis.");
        } elseif (strlen($club) < 2) {
            throw new \InvalidArgumentException("Le club doit contenir au moins 2 caractères.");
        }

        if (empty($position)) {
            throw new \InvalidArgumentException("La position est requise.");
        }

        if ($team_id===null) {
            throw new \InvalidArgumentException("L'équipe est requise.");
        } elseif ($team_id===0) {
            throw new \InvalidArgumentException("L'équipe est requise.");
        }

        // Initialisation des propriétés
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->country = $country;
        $this->club = $club;
        $this->position = $position;
        $this->team_id = $team_id;
    }

    // Getters pour accéder aux propriétés
    public function getId(): ?int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstname;
    }

    public function getLastName(): string {
        return $this->lastname;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function getClub(): string {
        return $this->club;
    }

    public function getPosition(): string {
        return $this->position;
    }

    public function getTeamId(): int {
        return $this->team_id;
    }

    // Setters pour modifier les propriétés
    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function setFirstName (string $firstname): void {
        if (empty($firstname)) {
            throw new \InvalidArgumentException("Le prénom du joueur est requis.");
        } else if (strlen($firstname) < 2) {
            throw new \InvalidArgumentException("Le prénom du joueur doit contenir au moins 2 caractères.");
        }

        $this->firstname = $firstname;
    }

    public function setLastName(string $lastname): void {
        if (empty($lastname)) {
            throw new \InvalidArgumentException("Le nom du joueur est requis.");
        } else if (strlen($lastname) < 2) {
            throw new \InvalidArgumentException("Le nom du joueur doit contenir au moins 2 caractères.");
        }

        $this->lastname = $lastname;
    }

    public function setCountry(string $country): void {
        if (empty($country)) {
            throw new \InvalidArgumentException("Le pays est requis.");
        } elseif (strlen($country) < 2) {
            throw new \InvalidArgumentException("Le pays doit contenir au moins 2 caractères.");
        }

        $this->country = $country;
    }

    public function setClub(string $club): void {
        if (empty($club)) {
            throw new \InvalidArgumentException("Le club est requis.");
        } elseif (strlen($club) < 2) {
            throw new \InvalidArgumentException("Le club doit contenir au moins 2 caractères.");
        }

        $this->club = $club;
    }

    public function setPosition(string $position): void {
        if (empty($position)) {
            throw new \InvalidArgumentException("La position est requise.");
        }

        $this->position = $position;
    }

    public function setTeamId(int $team_id): void {
        $this->team_id = $team_id;
    }
}

// class Player
// {
//     private ?int $id;
//     private string $firstname;
//     private string $lastname;
//     private ?string $country;
//     private ?string $club;
//     private string $position;
//     private ?int $team_id;

//     public function __construct(string $firstname, string $lastname, ?string $country, ?string $club, string $position, ?int $team_id, ?int $id = null)
//     {
//         $this->id = $id;
//         $this->firstname = $firstname;
//         $this->lastname = $lastname;
//         $this->country = $country;
//         $this->club = $club;
//         $this->position = $position;
//         $this->team_id = $team_id;
//     }

//     public function validate(): array
//     {
//         $errors = [];
//         if (empty($this->firstname) || mb_strlen($this->firstname) < 1) $errors[] = "Le prénom est requis.";
//         if (empty($this->lastname) || mb_strlen($this->lastname) < 1) $errors[] = "Le nom est requis.";
//         if (empty($this->position)) $errors[] = "La position est requise.";
//         if ($this->team_id === null || $this->team_id === 0) $errors[] = "Une équipe doit être sélectionnée.";
//         return $errors;
//     }

//     // getters
//     public function getId(): ?int { return $this->id; }
//     public function getFirstname(): string { return $this->firstname; }
//     public function getLastname(): string { return $this->lastname; }
//     public function getCountry(): ?string { return $this->country; }
//     public function getClub(): ?string { return $this->club; }
//     public function getPosition(): string { return $this->position; }
//     public function getTeamId(): ?int { return $this->team_id; }
// }