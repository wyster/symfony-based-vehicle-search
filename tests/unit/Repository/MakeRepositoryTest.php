<?php

declare(strict_types=1);

namespace Test\Repository;

use App\Entity\Make;
use App\Entity\VehicleType;
use App\Repository\Exception\RowNotFoundException;
use App\Repository\MakeRepository;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Test\UnitTester;

class MakeRepositoryTest extends Unit
{
    protected UnitTester $tester;

    public function testFindByIdNotFoundException(): void
    {
        $this->expectException(RowNotFoundException::class);
        $this->tester->grabService(MakeRepository::class)->findById(1);
    }

    public function testFindByCodeAndTypeNotFoundException(): void
    {
        $this->expectException(RowNotFoundException::class);
        $this->tester->grabService(MakeRepository::class)->findByCodeAndType('V', 1);
    }

    public function testFindByCodeAndType(): void
    {
        $makeData = ['id' => 1, 'type_id' => 1, 'code' => 'BUIC', 'description' => 'Buic'];
        $this->tester->haveInDatabase('vehicle_type', ['id' => 1, 'description' => 'Automobile', 'code' => 'V']);
        $this->tester->haveInDatabase('make', $makeData);
        $result = $this->tester->grabService(MakeRepository::class)->findByCodeAndType('BUIC', 1);
        $this->assertInstanceOf(
            Make::class,
            $result
        );
        $this->assertInstanceOf(
            VehicleType::class,
            $result->getType()
        );
        $this->assertSame(
            $makeData['id'],
            $result->getId()
        );
        $this->assertSame(
            $makeData['code'],
            $result->getCode()
        );
        $this->assertSame(
            $makeData['description'],
            $result->getDescription()
        );
    }

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
