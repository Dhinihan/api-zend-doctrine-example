<?php
namespace Test;

use Test\ApiTester;

class ExampleCest
{

    private $examples;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $this->examples = [
            'example' => [
                'description' => 'An Example',
                'id' => 'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34',
            ],
            'another example' => [
                'description' => 'Another Example',
                'id' => '4b6771b8-74ca-11e7-b5a5-be2e44b06b34'
            ]
        ];
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToGetList(ApiTester $I)
    {
        $I->haveInDatabase('example', $this->examples['example']);
        $I->haveInDatabase('example', $this->examples['another example']);

        $I->sendGET('/application');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['page' => 1]);
        $I->seeResponseContainsJson(['page_size' => 25]);
        $I->seeResponseContainsJson(['total_items' => 2]);
        $I->seeResponseContainsJson([
            'items' => [
                $this->examples['example'],
                $this->examples['another example'],
            ]
        ]);
    }

    public function tryToGet(ApiTester $I)
    {
        $I->haveInDatabase('example', $this->examples['example']);

        $I->sendGET('/application/de5ff4ce-74c8-11e7-b5a5-be2e44b06b34');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($this->examples['example']);
    }

    public function tryToPost(ApiTester $I)
    {
        $newExample = ['description' => 'Yet another example'];
        $I->sendPOST('/application', $newExample);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($newExample);
        $I->seeInDatabase('example', $newExample);
    }

    public function tryToPut(ApiTester $I)
    {
        $I->haveInDatabase('example', $this->examples['example']);
        $betterExample = ['description' => 'A better example'];
        $I->sendPUT('/application/de5ff4ce-74c8-11e7-b5a5-be2e44b06b34', $betterExample);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($betterExample);
        $I->seeInDatabase('example', $betterExample);
    }

    public function tryToDelete(ApiTester $I)
    {
        $I->haveInDatabase('example', $this->examples['example']);
        $I->sendDELETE('/application/de5ff4ce-74c8-11e7-b5a5-be2e44b06b34');
        $I->seeResponseCodeIs(204);
        $I->dontSeeInDatabase('example', $this->examples['example']);
    }
}
