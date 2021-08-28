<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Inflector\Inflector;
use Symfony\Component\String\Inflector\EnglishInflector;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @Groups("team")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"team", "league"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({"team", "league"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $strip;

    /**
     * @Groups("team")
     * @ORM\ManyToOne(targetEntity=League::class, inversedBy="teams")
     */
    private $league;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStrip(): ?string
    {
        return $this->strip;
    }

    public function setStrip(?string $strip): self
    {
        $this->strip = $strip;

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function exchangeData($params) {

        foreach ($params as $k => $p) {
            if (property_exists($this, $k)) {
                $this->{'set'.ucfirst($k)}($p);
            }
        }

        return $this;
    }
}
