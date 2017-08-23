<?php

namespace Model\Value\Factory;

use Assert\Assertion;
use Model\Value\Address;
use Model\Value\CEP;
use Model\Value\StreetInfo;

class AddressFactory
{
    public function createFromInput(array $input): Address
    {
        Assertion::keyIsset($input, 'cep');
        $cep = new CEP($input['cep']);

        Assertion::keyIsset($input, 'street_info');
        Assertion::keyIsset($input['street_info'], 'street_number');
        $streetNumber = $input['street_info']['street_number'];
        $otherInfo = $input['street_info']['other_info'] ?? null;
        $streetInfo = new StreetInfo($streetNumber, $otherInfo);

        return new Address($cep, $streetInfo);
    }
}
