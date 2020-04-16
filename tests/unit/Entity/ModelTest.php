<?php

declare(strict_types=1);

namespace Test\Entity;

use App\Entity\Make;
use App\Entity\Model;
use App\Entity\VehicleType;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Test\UnitTester;

class ModelTest extends Unit
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

        $model = new Model();
        $model->setType($vehicleType);
        $model->setMake($make);
        $model->setDescription('RIVIERA');

        $em->flush();

        $this->assertIsInt($model->getId());
        $this->assertInstanceOf(VehicleType::class, $model->getType());
        $this->assertInstanceOf(Make::class, $model->getMake());
        $this->assertSame('RIVIERA', $model->getDescription());
    }
}
