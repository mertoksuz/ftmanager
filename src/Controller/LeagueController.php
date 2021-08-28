<?php
namespace App\Controller;

use App\Service\LeagueService;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends BaseController
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

        return $this->response($leagues, ['league']);
    }
}