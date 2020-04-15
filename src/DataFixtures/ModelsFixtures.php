<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Make;
use App\Entity\Model;
use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Laminas\Hydrator\ClassMethodsHydrator;
use Psr\Log\LoggerInterface;

class ModelsFixtures extends Fixture implements DependentFixtureInterface
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
            MakesFixtures::class
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $hydrator = new ClassMethodsHydrator();
        $models = json_decode(file_get_contents(__DIR__ . '/data/models.json'), true, 512, JSON_THROW_ON_ERROR);
        $this->logger->info(sprintf('models count: %s', count($models)));
        $vehicleRepository = $manager->getRepository(VehicleType::class);
        $makeRepository = $manager->getRepository(Make::class);
        foreach ($models as $data) {
            try {
                $type = $vehicleRepository->findByCode($data['type']);
            } catch (Exception $e) {
                $this->logger->error(sprintf('fetch type: %s %s', $e->getMessage(), json_encode($data, JSON_THROW_ON_ERROR)));
                continue;
            }
            try {
                $make = $makeRepository->findByCodeAndType($data['group'], $type->getId());
            } catch (Exception $e) {
                $this->logger->error(sprintf('make: %s %s', $e->getMessage(), json_encode($data, JSON_THROW_ON_ERROR)));
                continue;
            }
            $model = new Model();
            unset($data['group'], $data['type']);
            $model->setType($type);
            $model->setMake($make);
            $hydrator->hydrate($data, $model);
            $manager->persist($model);
        }

        $manager->flush();
    }
}
