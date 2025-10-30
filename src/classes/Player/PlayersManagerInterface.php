<?php

namespace Player;

interface PlayersManagerInterface {
    public function getPlayers(): array;
    public function getPlayerById(int $id): ?Player;
    public function addPlayer(Player $player): int;
    public function updatePlayer(Player $player): bool;
    public function removePlayer(int $id): bool;
}