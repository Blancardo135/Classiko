<?php

class Team
{
    private $id;
    private $name;
    private $nbPlayers;
    private $descr;
    private $sport;

    public function __construct($name, $nbPlayers, $descr, $sport, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nbPlayers = $nbPlayers;
        $this->descr = $descr;
        $this->sport = $sport;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNbPlayers()
    {
        return $this->nbPlayers;
    }

    public function getDescr()
    {
        return $this->descr;
    }

    public function getSport()
    {
        return $this->sport;
    }
}