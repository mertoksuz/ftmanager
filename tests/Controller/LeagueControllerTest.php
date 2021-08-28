<?php
namespace Controller;

use App\Controller\LeagueController;
use App\Service\LeagueService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LeagueControllerTest extends WebTestCase
{
    private $testLeagues = [];
    private $serializer;

    public function setUp(): void
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);

        $this->testLeagues = [
            [
                'id' => 1,
                'name' => 'L1'
            ],
            [
                'id' => 2,
                'name' => 'L2'
            ],
        ];

    }

    public function test_index_returns_data()
    {
        $serviceMock = $this->getMockBuilder(LeagueService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getLeagues'])
            ->getMock();

        $serviceMock->method('getLeagues')->willReturn($this->testLeagues);

        $leagueController = new LeagueController($serviceMock);
        $leagueController->setSerializer($this->serializer);

        $data = json_encode(json_decode($leagueController->index()->getContent(), true)['data']);

        $this->assertEquals(json_encode($this->testLeagues), $data);
    }

    public function test_index_returns_no_data()
    {
        $serviceMock = $this->getMockBuilder(LeagueService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getLeagues'])
            ->getMock();

        $serviceMock->method('getLeagues')->willReturn([]);

        $leagueController = new LeagueController($serviceMock);
        $leagueController->setSerializer($this->serializer);

        $data = json_encode(json_decode($leagueController->index()->getContent(), true)['data']);

        $this->assertEquals(json_encode([]), $data);
    }
}