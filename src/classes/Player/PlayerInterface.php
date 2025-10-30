<?php

namespace Player;

interface PlayerInterface
{
    public function getId(): int;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getCountry(): string;
    public function getPosition(): string;
    public function getTeamId(): int;
    public function getClub(): string;


    public function setId(int $id): void;
    public function setFirstName(string $firstName): void;
    public function setLastName(string $lastName): void;
    public function setCountry(string $country): void;
    public function setPosition(string $position): void;
    public function setTeamId(int $teamId): void;
    public function setClub(string $club): void;
}
