<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * AbstractService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }
}