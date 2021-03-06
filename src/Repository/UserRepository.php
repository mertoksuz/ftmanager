<?php

namespace App\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByIdentifier($identifier)
    {
    }

    public function loadUserByUsername(string $username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}