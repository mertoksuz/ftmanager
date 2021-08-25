<?php
namespace App\Controller;

use App\Service\LeagueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends AbstractController
{
    /** @var LeagueService */
    private $leagueService;

    /**
     * LeagueController constructor.
     * @param LeagueService $leagueService
     */
    public function __construct(LeagueService $leagueService)
    {
        $this->leagueService = $leagueService;
    }

    /**
     * @Route("/api/leagues", name="league_index", methods={"GET"})
     */
    public function index()
    {
        $leagues = $this->leagueService->getLeagues();

        return new JsonResponse(['error' => false, 'data' => $leagues]);
    }
}