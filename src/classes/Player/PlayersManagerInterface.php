<?php

namespace Player;

interface PlayersManagerInterface {
    public function getPlayers(?int $ownerUserId = null): array;
    public function getPlayerById(int $id): ?Player;
    public function addPlayer(Player $player, ?int $ownerUserId = null): int;
    public function updatePlayer(Player $player): bool;
    public function removePlayer(int $id): bool;
}