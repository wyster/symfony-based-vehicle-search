<?php

declare(strict_types=1);

namespace Test\Repository;

use App\Entity\VehicleType;
use App\Repository\Exception\RowNotFoundException;
use App\Repository\VehicleTypeRepository;
use Codeception\Test\Unit;
use Test\UnitTester;

class VehicleTypeRepositoryTest extends Unit
{
    protected UnitTester $tester;

    public function testFindByIdNotFoundException(): void
    {
        $this->expectException(RowNotFoundException::class);
        $this->tester->grabService(VehicleTypeRepository::class)->findById(1);
    }

    public function testFindByCodeAndTypeNotFoundException(): void
    {
        $this->expectException(RowNotFoundException::class);
        $this->tester->grabService(VehicleTypeRepository::class)->findByCode('V');
    }

    public function testFindByCodeAndType(): void
    {
        $vehicleTypeData = ['id' => 1, 'code' => 'B', 'description' => 'Buic'];
        $this->tester->haveInDatabase('vehicle_type', $vehicleTypeData);
        $result = $this->tester->grabService(VehicleTypeRepository::class)->findById(1);
        $this->assertInstanceOf(
            VehicleType::class,
            $result
        );
        $this->assertSame(
            $vehicleTypeData['id'],
            $result->getId()
        );
        $this->assertSame(
            $vehicleTypeData['code'],
            $result->getCode()
        );
        $this->assertSame(
            $vehicleTypeData['description'],
            $result->getDescription()
        );
    }
}
