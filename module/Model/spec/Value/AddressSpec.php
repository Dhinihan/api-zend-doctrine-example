<?php

namespace spec\Model\Value;

use Model\Value\Address;
use Model\Value\AggregateValueInterface;
use Model\Value\CEP;
use Model\Value\StreetInfo;
use PhpSpec\ObjectBehavior;

class AddressSpec extends ObjectBehavior
{
    public function let(CEP $cep, StreetInfo $streetInfo)
    {
        $cep->__toString()->willReturn('12345678');
        $streetInfo->__toString()->willReturn('number 37, ap. 345 - Just next to the Starbucks');
        $this->beConstructedWith($cep, $streetInfo);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Address::class);
    }

    public function it_is_a_aggregate_value()
    {
        $this->shouldHaveType(AggregateValueInterface::class);
    }

    public function it_can_be_turned_into_an_array()
    {
        $addressArray = $this->toArray();
        $addressArray->shouldHaveKeyWithValue("cep", '12345678');
        $addressArray->shouldHaveKeyWithValue("street_info", 'number 37, ap. 345 - Just next to the Starbucks');
    }

    public function it_can_be_turned_into_a_string()
    {
        $this->shouldBeLike('cep: 12345678, street_info: number 37, ap. 345 - Just next to the Starbucks');
    }
}
