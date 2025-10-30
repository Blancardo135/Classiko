<?php

namespace Team;

class Team implements TeamInterface{
    private int $id;
    private string $name;
    private int $nbPlayers;
    private string $descr;
    private string $sport;

   
    public function __construct(?int $id, string $name, int $nbPlayers, string $descr, string $sport) 
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Le nom de l’équipe est requis.");
        } elseif (strlen(trim($name)) < 2) {
            throw new \InvalidArgumentException("Le nom de l’équipe doit contenir au moins 2 caractères.");
        }

        if ($nbPlayers < 1) {
            throw new \InvalidArgumentException("Le nombre de joueurs doit être d’au moins 1.");
        }

        if (empty($descr)) {
            throw new \InvalidArgumentException("La description est requise.");
        } elseif (strlen(trim($descr)) < 5) {
            throw new \InvalidArgumentException("La description doit contenir au moins 5 caractères.");
        }

        if (empty($sport)) {
            throw new \InvalidArgumentException("Le sport est requis.");
        } elseif (strlen(trim($sport)) < 2) {
            throw new \InvalidArgumentException("Le sport doit contenir au moins 2 caractères.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->nbPlayers = $nbPlayers;
        $this->descr = $descr;
        $this->sport = $sport;
    }

    public function getId(): int
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

    public function setId(int $id): void
    {
        $this->id = $id ?? 0;
        }

    public function setName(string $name): void
    {
        if (empty($name) || strlen(trim($name)) < 2) {
            throw new \InvalidArgumentException("Le nom de l’équipe doit contenir au moins 2 caractères.");
        }
        $this->name = $name;
    }

    public function setNbPlayers(int $nbPlayers): void
    {
        if ($nbPlayers < 1) {
            throw new \InvalidArgumentException("Le nombre de joueurs doit être d’au moins 1.");
        }
        $this->nbPlayers = $nbPlayers;
    }

    public function setDescr(string $descr): void
    {
        if (empty($descr) || strlen(trim($descr)) < 5) {
            throw new \InvalidArgumentException("La description doit contenir au moins 5 caractères.");
        }
        $this->descr = $descr;
    }

    public function setSport(string $sport): void
    {
        if (empty($sport) || strlen(trim($sport)) < 2) {
            throw new \InvalidArgumentException("Le sport doit contenir au moins 2 caractères.");
        }
        $this->sport = $sport;
    }
    
}