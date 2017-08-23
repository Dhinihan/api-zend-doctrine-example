<?php

namespace spec\Model\Value\Factory;

use Model\Value\Address;
use Model\Value\Factory\AddressFactory;
use PhpSpec\ObjectBehavior;

class AddressFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AddressFactory::class);
    }

    public function it_can_build_an_address_from_an_input_array()
    {
        $input = [
            'cep' => '23456-781',
            'street_info' => [
                'street_number' => '234',
                'other_info' => 'Right around the corner',
            ]
        ];
        $address = $this->createFromInput($input);
        $address->shouldBeAnInstanceOf(Address::class);

        $address->shouldBeLike('cep: 23456781, street_info: 234, Right around the corner');
    }

    public function it_cannot_create_address_without_a_cep()
    {
        $input = [
            'street_info' => [
                'street_number' => '234',
                'other_info' => 'Right around the corner',
            ]
        ];
    }

    public function it_cannot_create_an_address_without_a_street_number()
    {
        $input = [
            'cep' => '23456-781',
        ];
        $address = $this->shouldThrow('InvalidArgumentException')->duringCreateFromInput($input);
        $input = [
            'cep' => '23456-781',
            'street_info' => [
                'other_info' => 'Right around the corner',
            ]
        ];
        $address = $this->shouldThrow('InvalidArgumentException')->duringCreateFromInput($input);
    }
    public function it_can_build_an_address_without_other_info()
    {
        $input = [
            'cep' => '23456-781',
            'street_info' => [
                'street_number' => '234',
            ]
        ];
        $address = $this->createFromInput($input);
        $address->shouldBeAnInstanceOf(Address::class);

        $address->shouldBeLike('cep: 23456781, street_info: 234');
    }
}
