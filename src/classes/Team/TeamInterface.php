<?php

namespace Team;

interface TeamInterface
{
    public function getId(): ?int;
    public function getName(): string;
    public function getNbPlayers(): int;
    public function getDescr(): string;
    public function getSport(): string;

    public function setId(int $id): void;
    public function setName(string $name): void;
    public function setNbPlayers(int $nbPlayers): void;
    public function setDescr(string $descr): void;
    public function setSport(string $sport): void;
}