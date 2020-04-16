<?php

declare(strict_types=1);

namespace Test\Entity;

use App\Entity\VehicleType;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;
use Test\UnitTester;

class VehicleTypeTest extends Unit
{
    protected UnitTester $tester;

    private array $vehicleTypeData = [
        'code' => 'V',
        'description' => 'Automobile'
    ];

    public function testSettersAndGetters(): void
    {
        $em = $this->tester->grabService(EntityManagerInterface::class);
        $searchLog = new VehicleType();
        $hydrator = new ClassMethodsHydrator();
        $hydrator->hydrate($this->vehicleTypeData, $searchLog);
        $em->persist($searchLog);
        $em->flush();

        $this->assertEquals($this->vehicleTypeData['code'], $searchLog->getCode());
        $this->assertEquals($this->vehicleTypeData['description'], $searchLog->getDescription());
    }
}
