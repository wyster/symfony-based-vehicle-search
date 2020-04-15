<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

// @todo в фикстурах есть не уникальные значения, не понятно допустимо ли это
// @ORM\Table(uniqueConstraints={@UniqueConstraint(name="code_and_type", columns={"code", "type_id"})})
/**
 * @ORM\Entity(repositoryClass="App\Repository\MakeRepository")
 */
class Make
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
    private string $code;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="code")
     */
    private VehicleType $type;
    /**
     * @ORM\Column(type="string")
     */
    private string $description;

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

    public function getType(): VehicleType
    {
        return $this->type;
    }

    public function setType(VehicleType $type): void
    {
        $this->type = $type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
