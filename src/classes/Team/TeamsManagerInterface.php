<?php

namespace Team;

interface TeamsManagerInterface
{
    public function getTeams(): array;
    public function addTeam(Team $team): int;
    public function removeTeam(int $id): bool;
    public function getTeamById(int $id): ?Team;
    public function updateTeam(Team $team): bool;
}
