<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Make;
use App\Repository\Exception\RowNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Make::class);
    }

    /**
     * @param int $id
     * @return Make
     * @throws RowNotFoundException
     */
    public function findById(int $id): Make
    {
        $row = parent::find($id);

        if ($row === null) {
            throw new RowNotFoundException('Row not found');
        }

        return $row;
    }

    public function findByCodeAndType(string $code, int $type): Make
    {
        $row = $this->createQueryBuilder('v')
            ->andWhere('v.code = :code')
            ->setParameter('code', $code)
            ->andWhere('v.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult();

        if ($row === null) {
            throw new RowNotFoundException('Row not found');
        }
        return $row;
    }
}
