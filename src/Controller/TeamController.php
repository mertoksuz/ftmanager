<?php
namespace App\Controller;

use App\Service\TeamService ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /** @var TeamService */
    private $teamService;

    /**
     * TeamController constructor.
     * @param TeamService $teamService
     */
    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * @Route("/api/teams", name="teams_index", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $teams = $this->teamService->getTeams();

        return new JsonResponse(['error' => false, 'data' => $teams]);
    }

    /**
     * @Route("/api/teams/{league}", name="teams_read", methods={"GET"})
     * @param int $league League ID
     * @return JsonResponse
     */
    public function read(int $league): JsonResponse
    {
        $leagues = $this->teamService->getTeamsByLeague($league);

        return new JsonResponse(['error' => false, 'data' => $leagues]);
    }
}