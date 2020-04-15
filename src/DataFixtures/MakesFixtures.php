<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Make;
use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Laminas\Hydrator\ClassMethodsHydrator;
use Psr\Log\LoggerInterface;

class MakesFixtures extends Fixture implements DependentFixtureInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getDependencies(): array
    {
        return [
            VehicleTypesFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $hydrator = new ClassMethodsHydrator();
        $makes = json_decode(file_get_contents(__DIR__ . '/data/makes.json'), true, 512, JSON_THROW_ON_ERROR);
        $this->logger->info(sprintf('makes count: %s', count($makes)));
        $vehicleRepository = $manager->getRepository(VehicleType::class);
        foreach ($makes as $data) {
            try {
                $type = $vehicleRepository->findByCode($data['type']);
            } catch (Exception $e) {
                $this->logger->error(sprintf('fetch type: %s %s', $e->getMessage(), json_encode($data, JSON_THROW_ON_ERROR)));
                continue;
            }
            $make = new Make();
            unset($data['type']);
            $make->setType($type);
            $hydrator->hydrate($data, $make);
            $manager->persist($make);
        }

        $manager->flush();
    }
}
