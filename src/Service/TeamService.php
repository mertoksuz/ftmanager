<?php
namespace App\Service;

use App\Entity\Team;

class TeamService extends AbstractService
{
    public function getTeams(): array
    {
        return $this->getEm()->getRepository(Team::class)->findAll();
    }

    public function getTeamsByLeague(int $league): array
    {
        return $this->getEm()->getRepository(Team::class)->findBy(['league' => $league]);
    }
}