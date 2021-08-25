<?php
namespace App\Controller;

use App\Exception\AuthException;
use App\Service\JwtService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /** @var JwtService */
    private $jwtService;

    /**
     * AuthController constructor.
     * @param JwtService $jwtService
     */
    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * @Route("/api/login", name="auth_login", methods={"POST"})
     */
    public function login(RequestStack $requestStack)
    {
        $body = json_decode($requestStack->getMainRequest()->getContent(), true);

        if (empty($body['username']) || empty($body['password'])) {
            throw new AuthException('Invalid credentials');
        }

        $token = $this->jwtService->encode([
            'username' => $body['username'],
            'password' => $body['password']
        ]);

        return new JsonResponse(['token' => $token]);
    }
}