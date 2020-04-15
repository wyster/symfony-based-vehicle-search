<?php

declare(strict_types=1);

namespace Test;

class MakesListCest
{
    public function tryToTest(FunctionalTester $I): void
    {
        $I->haveInDatabase('vehicle_type', ['id' => 1, 'description' => 'Automobile', 'code' => 'V']);
        $I->haveInDatabase('make', ['id' => 1, 'type_id' => 1, 'code' => 'MCLA', 'description' => 'Mclaren']);
        $I->amOnPage('/makes/V');
        $I->canSeeResponseCodeIs(200);
        $content = $I->grabPageSource();
        $I->assertStringContainsString('<option value="1">Mclaren</option>', $content);
    }
}
