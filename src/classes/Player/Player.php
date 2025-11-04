<?php

namespace Player;

// Inclusion du système de traduction
require_once __DIR__ . '/../config/translations.php';
require_once __DIR__ . '/../config/lang.php';

class Player implements PlayerInterface
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private string $country;
    private string $club;
    private string $position;
    private ?int $team_id;

    public function __construct(?int $id, string $firstname, string $lastname, string $country, string $club, string $position, ?int $team_id)
    {
        // Vérification des données
        if (empty($firstname)) {
            throw new \InvalidArgumentException(t('error_firstname_required'));
        } else if (strlen($firstname) < 2) {
            throw new \InvalidArgumentException(t('error_firstname_min_length'));
        }

        if (empty($lastname)) {
            throw new \InvalidArgumentException(t('error_lastname_required'));
        } else if (strlen($lastname) < 2) {
            throw new \InvalidArgumentException(t('error_lastname_min_length'));
        }

        if (empty($country)) {
            throw new \InvalidArgumentException(t('error_country_required'));
        } elseif (strlen($country) < 2) {
            throw new \InvalidArgumentException(t('error_country_min_length'));
        }

        if (empty($club)) {
            throw new \InvalidArgumentException(t('error_club_required'));
        } elseif (strlen($club) < 2) {
            throw new \InvalidArgumentException(t('error_club_min_length'));
        }

        if (empty($position)) {
            throw new \InvalidArgumentException(t('error_position_required'));
        }

        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->country = $country;
        $this->club = $club;
        $this->position = $position;
        $this->team_id = $team_id;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstname;
    }

    public function getLastName(): string
    {
        return $this->lastname;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getClub(): string
    {
        return $this->club;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setFirstName(string $firstname): void
    {
        if (empty($firstname)) {
            throw new \InvalidArgumentException(t('error_firstname_required'));
        } else if (strlen($firstname) < 2) {
            throw new \InvalidArgumentException(t('error_firstname_min_length'));
        }
        $this->firstname = $firstname;
    }

    public function setLastName(string $lastname): void
    {
        if (empty($lastname)) {
            throw new \InvalidArgumentException(t('error_lastname_required'));
        } else if (strlen($lastname) < 2) {
            throw new \InvalidArgumentException(t('error_lastname_min_length'));
        }
        $this->lastname = $lastname;
    }

    public function setCountry(string $country): void
    {
        if (empty($country)) {
            throw new \InvalidArgumentException(t('error_country_required'));
        } elseif (strlen($country) < 2) {
            throw new \InvalidArgumentException(t('error_country_min_length'));
        }
        $this->country = $country;
    }

    public function setClub(string $club): void
    {
        if (empty($club)) {
            throw new \InvalidArgumentException(t('error_club_required'));
        } elseif (strlen($club) < 2) {
            throw new \InvalidArgumentException(t('error_club_min_length'));
        }
        $this->club = $club;
    }

    public function setPosition(string $position): void
    {
        if (empty($position)) {
            throw new \InvalidArgumentException(t('error_position_required'));
        }
        $this->position = $position;
    }

    public function setTeamId(?int $team_id): void
    {
        $this->team_id = $team_id;
    }
}
