<?php

declare(strict_types=1);

namespace Test\Entity;

use App\Entity\SearchLog;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;
use Test\UnitTester;

class SearchLogTest extends Unit
{
    protected UnitTester $tester;

    private array $logData = [
        'vehicle_type' => 'V',
        'make_abbr' => 'TESL',
        'found_models' => 500,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36',
        'request_time' => 100.0
    ];

    public function testSettersAndGetters(): void
    {
        $em = $this->tester->grabService(EntityManagerInterface::class);
        $searchLog = new SearchLog();
        $hydrator = new ClassMethodsHydrator();
        $hydrator->hydrate($this->logData, $searchLog);
        $em->persist($searchLog);
        $em->flush();

        $data = $hydrator->extract($searchLog);
        unset($data['id']);
        $this->assertSame($this->logData, $data);
    }
}
