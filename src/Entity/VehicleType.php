<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleTypeRepository")
 */
class VehicleType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @ORM\Column(type="string", length=1, unique=true)
     */
    private string $code;
    /**
     * @ORM\Column(type="string")
     */
    private string $description;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Model", mappedBy="type")
     */
    private Collection $models;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Make", mappedBy="type")
     */
    private Collection $makes;

    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->makes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection|Make[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function getMakes(): Collection
    {
        return $this->makes;
    }
}
