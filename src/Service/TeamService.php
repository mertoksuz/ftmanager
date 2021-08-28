<?php
namespace App\Service;

use App\Entity\League;
use App\Entity\Team;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class TeamService extends AbstractService
{
    public function getTeams(?array $filters): array
    {
        if (isset($filters['league'])) {
            return $this->getEm()->getRepository(Team::class)->findBy(['league' => $filters['league']]);
        }

        return $this->getEm()->getRepository(Team::class)->findAll();
    }

    public function getTeam(int $team): Team
    {
        return $this->getEm()->getRepository(Team::class)->find($team);
    }

    public function updateTeam(int $team, ?array $params): Team
    {
        $team = $this->getEm()->getRepository(Team::class)->find($team);

        if (null === $team) {
            throw new ResourceNotFoundException("Team not found");
        }

        // Handle league update operation.
        if (isset($params['league'])) {
            $league = $this->getEm()->getRepository(League::class)->find($params['league']);

            if ($league) {
                $team->setLeague($league);
            }

            unset($params['league']);
        }

        // Exchange data with setters.
        $team = $team->exchangeData($params);

        // Update entity with new data/
        $this->getEm()->flush();

        return $team;
    }

    public function removeTeam(int $team): void
    {
        $team = $this->getEm()->getRepository(Team::class)->find($team);

        if (null === $team) {
            throw new ResourceNotFoundException("Team not found");
        }

        $this->getEm()->remove($team);
        $this->getEm()->flush();
    }
}