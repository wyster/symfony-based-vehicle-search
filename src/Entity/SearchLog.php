<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchLogRepository")
 */
class SearchLog
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
    private string $vehicleType;
    /**
     * @ORM\Column(type="string")
     */
    private string $makeAbbr;
    /**
     * @ORM\Column(type="integer")
     */
    private int $foundModels;
    /**
     * @ORM\Column(type="string")
     */
    private string $ipAddress;
    /**
     * @ORM\Column(type="string")
     */
    private string $userAgent;
    /**
     * In milliseconds
     * @ORM\Column(type="float")
     */
    private float $requestTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicleType(): string
    {
        return $this->vehicleType;
    }

    public function setVehicleType(string $vehicleType): void
    {
        $this->vehicleType = $vehicleType;
    }

    public function getMakeAbbr(): string
    {
        return $this->makeAbbr;
    }

    public function setMakeAbbr(string $makeAbbr): void
    {
        $this->makeAbbr = $makeAbbr;
    }

    public function getFoundModels(): int
    {
        return $this->foundModels;
    }

    public function setFoundModels(int $foundModels): void
    {
        $this->foundModels = $foundModels;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    public function getRequestTime(): float
    {
        return $this->requestTime;
    }

    public function setRequestTime(float $requestTime): void
    {
        $this->requestTime = $requestTime;
    }
}
