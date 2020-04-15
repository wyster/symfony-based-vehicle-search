<?php

declare(strict_types=1);

namespace Test;

class ModelCest
{
    public function tryToTest(FunctionalTester $I): void
    {
        $I->haveInDatabase('vehicle_type', ['id' => 1, 'description' => 'Automobile', 'code' => 'V']);
        $I->haveInDatabase('make', ['id' => 2, 'type_id' => 1, 'code' => 'BUIC', 'description' => 'Buic']);
        $I->haveInDatabase('model', ['id' => 1, 'type_id' => 1, 'make_id' => 2, 'description' => 'LESABRE']);
        $I->sendAjaxGetRequest('/models/1/2');
        $I->canSeeResponseCodeIs(200);
        $content = $I->grabPageSource();
        $I->assertStringContainsString('[{"id":1,"description":"LESABRE"}]', $content);
    }
}
