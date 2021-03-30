<?php

namespace api;

use Codeception\Util\HttpCode;

class ApplicationCest
{
    public function HomePage(\ApiTester $I)
    {
        $I->sendGET('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('api');
    }
}