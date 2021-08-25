<?php
namespace App\Service;

use App\Entity\League;

class LeagueService extends AbstractService
{
    /**
     * Returns all leagues presents in database.
     *
     * @return array
     */
    public function getLeagues(): array
    {
        return $this->getEm()->getRepository(League::class)->findAll();
    }
}