<?php
namespace App\Security;

use App\Exception\AuthException;
use App\Exception\InvalidJWTException;
use App\Service\JwtService;
use App\Service\UserService;
use Namshi\JOSE\JWT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;


class JWTGuardAuthenticator extends AbstractAuthenticator
{

    /** @var JwtService */
    private $jwtService;

    /** @var UserService */
    private $userService;

    /**
     * JWTGuardAuthenticator constructor.
     * @param JwtService $jwtService
     * @param $userService
     */
    public function __construct(JwtService $jwtService, UserService $userService)
    {
        $this->jwtService = $jwtService;
        $this->userService = $userService;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = $request->headers->get('Authorization');
        if (null === $apiToken) {
            throw new InvalidJWTException();
        }

        $headerParts = explode(' ', $request->headers->get('Authorization'));

        if (!(count($headerParts) === 2 && $headerParts[0] === 'Bearer')) {
            throw new InvalidJWTException('Malformed Authorization Header');
        }

        $credentials = $headerParts[1];

        try {
            $payload = $this->jwtService->decode($credentials);
        } catch (InvalidJWTException $e) {
            throw new AuthException($e->getMessage());
        } catch (\Exception $e) {
            throw new AuthException('Malformed JWT');
        }

        if (!isset($payload->username)) {
            throw new AuthException('Invalid JWT');
        }

        $username = $payload->username;

        $userBadge = new UserBadge($payload->username, function () use ($username) {
            return $this->userService->findByUsername($username);
        });

        return new Passport( $userBadge, new PasswordCredentials($payload->password) );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new AuthException('Invalid credentials');
    }
}