<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;
    /**
     * @ORM\Column(type="string")
     */
    private string $description;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="models")
     */
    private VehicleType $type;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Make", inversedBy="models")
     */
    private Make $make;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): VehicleType
    {
        return $this->type;
    }

    public function setType(VehicleType $type): void
    {
        $this->type = $type;
    }

    public function getMake(): Make
    {
        return $this->make;
    }

    public function setMake(Make $make): void
    {
        $this->make = $make;
    }
}
