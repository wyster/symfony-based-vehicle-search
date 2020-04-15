<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Make;
use App\Entity\VehicleType;

interface SearchServiceInterface
{
    public function search(Make $make, VehicleType $type): array;
}
