<?php
namespace App\Controller;

use App\Service\TeamService ;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends BaseController
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $filters = $request->query->all();

        $teams = $this->teamService->getTeams($filters);

        return $this->response($teams, ['team']);
    }

    /**
     * @Route("/api/teams/{team}", name="teams_read", methods={"GET"})
     * @param int $team
     * @return JsonResponse
     */
    public function read(int $team): Response
    {
        $teams = $this->teamService->getTeam($team);

        return $this->response($teams, ['team']);
    }

    /**
     * @Route("/api/teams/{team}", name="teams_update", methods={"PUT"})
     * @param int $team Team ID
     * @param RequestStack $requestStack
     * @return JsonResponse
     */
    public function update(int $team, RequestStack $requestStack): Response
    {
        $requestBody = json_decode($requestStack->getMainRequest()->getContent(), true);

        $team = $this->teamService->updateTeam($team, $requestBody);

        return $this->response($team, ['team']);
    }

    /**
     * @Route("/api/teams/{team}", name="teams_delete", methods={"DELETE"})
     * @param int $team
     * @return JsonResponse
     */
    public function delete(int $team): Response
    {
        $this->teamService->removeTeam($team);

        return $this->response([], [], null, Response::HTTP_NO_CONTENT);
    }
}