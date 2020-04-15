<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VehicleType;
use App\Repository\Exception\RowNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VehicleTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleType::class);
    }

    /**
     * @throws RowNotFoundException
     */
    public function findById(int $id): VehicleType
    {
        $row = parent::find($id);

        if ($row === null) {
            throw new RowNotFoundException('Row not found');
        }

        return $row;
    }

    public function findByCode(string $value): VehicleType
    {
        $row = $this->createQueryBuilder('v')
            ->andWhere('v.code = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();

        if ($row === null) {
            throw new RowNotFoundException('Row not found');
        }
        return $row;
    }

    public function fetchAllByAlphabet(): array
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.code', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
