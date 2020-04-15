<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Make;
use App\Entity\Model;
use App\Entity\SearchLog;
use App\Entity\VehicleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

final class SearchService implements SearchServiceInterface
{
    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $request)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $request;
    }

    public function search(Make $make, VehicleType $type): array
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('search');
        $results = $this->entityManager->getRepository(Model::class)->findByMakeAndType($make, $type);
        $event = $stopwatch->stop('search');
        $this->createLog($make, $type, count($results), $event);

        return $results;
    }

    private function createLog(Make $make, VehicleType $type, int $resultCount, StopwatchEvent $stopwatchEvent): void
    {
        $ip = '';
        $userAgent = '';
        if ($this->requestStack->getCurrentRequest()) {
            $ip = $this->requestStack->getCurrentRequest()->getClientIp() ?: '';
            $userAgent = $this->requestStack->getCurrentRequest()->headers->get('User-Agent', '');
        }

        $log = new SearchLog();
        $log->setIpAddress($ip);
        $log->setFoundModels($resultCount);
        $log->setUserAgent($userAgent);
        $log->setMakeAbbr($make->getCode());
        $log->setVehicleType($type->getCode());
        $log->setRequestTime($stopwatchEvent->getDuration());

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
