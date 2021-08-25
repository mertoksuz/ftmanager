<?php
namespace App\Service;

use Firebase\JWT\JWT;
use App\Exception\InvalidJWTException;

class JwtService
{
    const ALG = 'HS256';

    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param array $payload
     * @param int   $ttl
     *
     * @return string
     */
    public function encode(array $payload, $ttl = 86400)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;

        return JWT::encode($payload, $this->key);
    }

    /**
     * @param string $token
     *
     * @return mixed
     *
     * @throws InvalidJWTException
     */
    public function decode(string $token)
    {
        $jwt = JWT::decode($token, $this->key, ['HS256']);

        if ($this->isExpired($jwt->exp)) {
            throw new InvalidJWTException('Expired JWT');
        }

        return $jwt;
    }

    /**
     * @param int $exp
     *
     * @return bool
     */
    private function isExpired($exp)
    {
        if (isset($exp) && is_numeric($exp)) {
            return (time() - $exp) > 0;
        }

        return false;
    }
}