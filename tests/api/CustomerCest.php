<?php
namespace Test;

use Test\ApiTester;

class CustomerCest
{
    private $customers;

    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $this->customers = [];
        $this->customers['customer'] = [
            'name' => 'George',
            'id' => 'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34',
        ];
        $this->customers['another customer'] = array_merge(
            $this->customers['customer'],
            ['id' => '4b6771b8-74ca-11e7-b5a5-be2e44b06b34']
        );
    }

    public function _after(ApiTester $I)
    {
    }

    public function tryToGetListOfCustomers(ApiTester $I)
    {
        $I->haveInDatabase('customer', $this->customers['customer']);
        $I->haveInDatabase('customer', $this->customers['another customer']);

        $I->sendGET('/customer');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['page' => 1]);
        $I->seeResponseContainsJson(['page_size' => 25]);
        $I->seeResponseContainsJson(['total_items' => 2]);
        $I->seeResponseContainsJson([
            'items' => [
                $this->customers['customer'],
                $this->customers['another customer'],
            ]
        ]);
    }

    public function tryToCreateNewCustomer(ApiTester $I)
    {
        $I->sendPOST('/customer', ['name' => 'Hord Ford Darkenskull']);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson(['name' => 'Hord Ford Darkenskull']);
        $customerId = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeInDatabase('customer', [
            'id' => $customerId[0],
            'name' => 'Hord Ford Darkenskull'
        ]);
    }
}
