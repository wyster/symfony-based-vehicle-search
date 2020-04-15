<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Laminas\Hydrator\ClassMethodsHydrator;
use Psr\Log\LoggerInterface;

class VehicleTypesFixtures extends Fixture
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function load(ObjectManager $manager): void
    {
        $hydrator = new ClassMethodsHydrator();
        $vehicleTypes = json_decode(file_get_contents(__DIR__ . '/data/vehicle_types.json'), true, 512, JSON_THROW_ON_ERROR);
        $this->logger->info((sprintf('vehicle types count: %s', count($vehicleTypes))));
        foreach ($vehicleTypes as $data) {
            $vehicleType = new VehicleType();
            $hydrator->hydrate($data, $vehicleType);
            $manager->persist($vehicleType);
        }

        $manager->flush();
    }
}
