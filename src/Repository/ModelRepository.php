<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Make;
use App\Entity\Model;
use App\Entity\VehicleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function findByMakeAndType(Make $make, VehicleType $type): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.make = :make')
            ->setParameter('make', $make->getId())
            ->andWhere('v.type = :type')
            ->setParameter('type', $type->getId())
            ->getQuery()
            ->getArrayResult();
    }
}
