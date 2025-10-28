<?php
namespace Team;

interface TeamsManagerInterface{
    public function getTeams(): array;
    public function addTeam(Team $team): int;
    public function removeTeam(int $id): bool;
}