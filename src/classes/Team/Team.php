<?php

namespace Team;

// Inclusion du système de traduction
require_once __DIR__ . '/../../config/translations.php';
require_once __DIR__ . '/../../config/lang.php';

class Team implements TeamInterface {
    private ?int $id;
    private string $name;
    private int $nbPlayers;
    private string $descr;
    private string $sport;

    public function __construct(?int $id, string $name, int $nbPlayers, string $descr, string $sport) 
    {
        if (empty($name)) {
            throw new \InvalidArgumentException(t('error_team_name_required'));
        } elseif (strlen(trim($name)) < 2) {
            throw new \InvalidArgumentException(t('error_team_name_min_length'));
        }

        if ($nbPlayers < 1) {
            throw new \InvalidArgumentException(t('error_team_nbplayers_min'));
        }

        if (empty($descr)) {
            throw new \InvalidArgumentException(t('error_team_descr_required'));
        } elseif (strlen(trim($descr)) < 5) {
            throw new \InvalidArgumentException(t('error_team_descr_min_length'));
        }

        if (empty($sport)) {
            throw new \InvalidArgumentException(t('error_team_sport_required'));
        } elseif (strlen(trim($sport)) < 2) {
            throw new \InvalidArgumentException(t('error_team_sport_min_length'));
        }

        $this->id = $id;
        $this->name = $name;
        $this->nbPlayers = $nbPlayers;
        $this->descr = $descr;
        $this->sport = $sport;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNbPlayers(): int
    {
        return $this->nbPlayers;
    }

    public function getDescr(): string
    {
        return $this->descr;
    }

    public function getSport(): string
    {
        return $this->sport;
    }

    public function setId(?int $id): void
    {
        $this->id = $id ?? 0;
    }

    public function setName(string $name): void
    {
        if (empty($name) || strlen(trim($name)) < 2) {
            throw new \InvalidArgumentException(t('error_team_name_min_length'));
        }
        $this->name = $name;
    }

    public function setNbPlayers(int $nbPlayers): void
    {
        if ($nbPlayers < 1) {
            throw new \InvalidArgumentException(t('error_team_nbplayers_min'));
        }
        $this->nbPlayers = $nbPlayers;
    }

    public function setDescr(string $descr): void
    {
        if (empty($descr) || strlen(trim($descr)) < 5) {
            throw new \InvalidArgumentException(t('error_team_descr_min_length'));
        }
        $this->descr = $descr;
    }

    public function setSport(string $sport): void
    {
        if (empty($sport) || strlen(trim($sport)) < 2) {
            throw new \InvalidArgumentException(t('error_team_sport_min_length'));
        }
        $this->sport = $sport;
    }
}