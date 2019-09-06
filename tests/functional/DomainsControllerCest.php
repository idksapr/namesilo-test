<?php

use App\Utils\ObjectArrays;
use Codeception\Util\HttpCode;

class DomainsControllerCest
{
    public function testInvalidDomain(\FunctionalTester $I)
    {
        $I->sendAjaxGetRequest('domains/check', [
            'search' => 'err*-;ror'
        ]);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function testExisting(\FunctionalTester $I)
    {
        $I->sendAjaxGetRequest('domains/check', [
            'search' => 'existing'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $dtos = $I->grabJsonResponse();

        // compare values
        $I->assertCount(3, $dtos);

        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'com'));
        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'net'));
        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'club'));

        $I->assertFalse(ObjectArrays::filterEqualOne($dtos, 'tld', 'com')->available);
        $I->assertTrue(ObjectArrays::filterEqualOne($dtos, 'tld', 'net')->available);
        $I->assertTrue(ObjectArrays::filterEqualOne($dtos, 'tld', 'club')->available);
    }

    public function testNewDomain(\FunctionalTester $I)
    {
        $I->sendAjaxGetRequest('domains/check', [
            'search' => 'new-domain'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $dtos = $I->grabJsonResponse();

        // compare values
        $I->assertCount(3, $dtos);

        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'com'));
        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'net'));
        $I->assertNotNull(ObjectArrays::filterEqualOne($dtos, 'tld', 'club'));

        $I->assertTrue(ObjectArrays::filterEqualOne($dtos, 'tld', 'com')->available);
        $I->assertTrue(ObjectArrays::filterEqualOne($dtos, 'tld', 'net')->available);
        $I->assertTrue(ObjectArrays::filterEqualOne($dtos, 'tld', 'club')->available);

        $I->assertEquals(8.99, ObjectArrays::filterEqualOne($dtos, 'tld', 'com')->price);
        $I->assertEquals(9.99, ObjectArrays::filterEqualOne($dtos, 'tld', 'net')->price);
        $I->assertEquals(15.99, ObjectArrays::filterEqualOne($dtos, 'tld', 'club')->price);
    }
}
