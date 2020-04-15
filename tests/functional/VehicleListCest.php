<?php

declare(strict_types=1);

namespace Test;

class VehicleListCest
{
    public function tryToTest(FunctionalTester $I): void
    {
        $I->haveInDatabase('vehicle_type', ['id' => 1, 'description' => 'Automobile', 'code' => 'V']);
        $I->amOnPage('/');
        $I->canSeeResponseCodeIs(200);
        $content = $I->grabPageSource();
        $I->assertStringContainsString('<a href="/makes/V">Automobile</a>', $content);
    }
}
