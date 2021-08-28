<?php
namespace Controller;

use App\Controller\TeamController;
use App\Entity\League;
use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TeamControllerTest extends WebTestCase
{
    /**
     * @var Serializer
     */
    private $serializer;

    private $testTeams;

    public function setUp(): void
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);

        $this->testTeams = [
            [
                "id" => 1,
                'name' => 'Test Team 1',
                'strip' => 'Test Strip Team 1',
                'league' => [
                    'id' => 1,
                    'name' => 'Team League 1'
                ]
            ],
            [
                "id" => 2,
                'name' => 'Test Team 2',
                'strip' => 'Test Strip Team 2',
                'league' => [
                    'id' => 1,
                    'name' => 'Team League 1'
                ]
            ],
            [
                "id" => 3,
                'name' => 'Test Team 3',
                'strip' => 'Test Strip Team 3',
                'league' => [
                    'id' => 2,
                    'name' => 'Team League 2'
                ]
            ],
        ];
    }

    public function test_index_returns_data()
    {
        $serviceMock = $this->getMockBuilder(TeamService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getTeams'])
            ->getMock();

        $serviceMock->method('getTeams')->willReturn($this->testTeams);

        $request = new Request([], [], []);

        $teamController = new TeamController($serviceMock);
        $teamController->setSerializer($this->serializer);

        $data = json_encode(json_decode($teamController->index($request)->getContent(), true)['data']);

        $this->assertEquals(json_encode($this->testTeams), $data);
    }

    public function test_read_data()
    {
        $serviceMock = $this->getMockBuilder(TeamService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getTeam'])
            ->getMock();

        $testTeam = new Team();
        $testTeam->setName('test 1');
        $testTeam->setStrip('test 1 st');
        $testL = new League();
        $testL->setName('Test L');
        $testTeam->setLeague($testL);

        $serviceMock->method('getTeam')->willReturn($testTeam);

        $teamController = new TeamController($serviceMock);
        $teamController->setSerializer($this->serializer);

        $data = json_encode(json_decode($teamController->read(1)->getContent(), true)['data']);

        $serializedData = $this->serializer->serialize($testTeam, 'json', ['groups' => ['team']]);
        $this->assertEquals($serializedData, $data);
    }

    public function test_delete_data()
    {
        $serviceMock = $this->getMockBuilder(TeamService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['removeTeam'])
            ->getMock();

        $testTeam = new Team();
        $testTeam->setName('test 1');
        $testTeam->setStrip('test 1 st');
        $testL = new League();
        $testL->setName('Test L');
        $testTeam->setLeague($testL);

        $serviceMock->method('removeTeam');

        $teamController = new TeamController($serviceMock);
        $teamController->setSerializer($this->serializer);

        $controllerResponse = $teamController->delete(1);

        $statusCode = $controllerResponse->getStatusCode();

        $data = json_encode(json_decode($controllerResponse->getContent(), true)['data']);

        $this->assertEquals('[]', $data);
        $this->assertEquals(204, $statusCode);
    }
}