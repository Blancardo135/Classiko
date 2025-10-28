<?php

namespace Player;

interface PlayersManagerInterface {
    public function getPlayers(): array;
    public function addPlayer(Player $player): int;
    public function removePlayer(int $id): bool;
}