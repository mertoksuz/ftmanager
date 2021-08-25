<?php
namespace App\Service;

use App\Entity\User;

class UserService extends AbstractService
{
    public function findByUsername($username)
    {
        return $this->getEm()->getRepository(User::class)->loadUserByUsername($username);
    }
}