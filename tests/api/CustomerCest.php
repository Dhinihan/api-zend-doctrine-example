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
            'cpf' => '05774819400',
        ];
        $this->customers['another customer'] = array_merge(
            $this->customers['customer'],
            [
                'id' => '4b6771b8-74ca-11e7-b5a5-be2e44b06b34',
                'cpf' => '03456406835',
            ]
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
        $newCustomer = [
            'name' => 'Hord Ford Darkenskull',
            'cpf' => '35322813179'
        ];

        $I->sendPOST('/customer', $newCustomer);
        $I->seeResponseCodeIs(201);
        $I->seeResponseContainsJson($newCustomer);
        $customerId = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeInDatabase('customer', [
            'id' => $customerId[0],
            'name' => 'Hord Ford Darkenskull',
            'cpf' => '35322813179'
        ]);
    }

    public function tryToAddAnAddressToACustomer(ApiTester $I)
    {
        $customer = $this->customers['customer'];

        $I->haveInDatabase('customer', $customer);
        $address = [
            'cep' => '12345-123',
            'street_info' => [
                'street_number' => '34B',
                'other_info' => 'Third house from the second street.',
            ]
        ];
        $I->sendPOST("/customer/${customer['id']}/add-address", $address);
        $I->seeResponseCodeIs(200);

        $address['street_info'] = '34B, Third house from the second street.';
        $address['cep'] = '12345123';

        $I->seeResponseContainsJson([
            'address' => $address
        ]);

        $customerId = $I->grabDataFromResponseByJsonPath('$.id');

        $I->seeInDatabase('customer', [
            'id' => $customerId[0],
            'cep' => '12345123',
            'street_number' => '34B',
            'street_other_info' => 'Third house from the second street.',
        ]);
    }
}
