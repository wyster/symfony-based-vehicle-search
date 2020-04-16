<?php

declare(strict_types=1);

namespace Test\Entity;

use App\Entity\Make;
use App\Entity\VehicleType;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Test\UnitTester;

class MakeTest extends Unit
{
    protected UnitTester $tester;

    public function testSetters(): void
    {
        $em = $this->tester->grabService(EntityManagerInterface::class);
        $vehicleType = new VehicleType();
        $vehicleType->setCode('V');
        $vehicleType->setDescription('Automobile');
        $em->persist($vehicleType);

        $make = new Make();
        $make->setType($vehicleType);
        $make->setDescription('Buic');
        $make->setCode('BUIC');
        $em->persist($make);
        $em->flush();
    }
}
