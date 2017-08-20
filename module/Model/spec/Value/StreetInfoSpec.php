<?php

namespace spec\Model\Value;

use Model\Value\AggregateValueInterface;
use Model\Value\StreetInfo;
use PhpSpec\ObjectBehavior;

class StreetInfoSpec extends ObjectBehavior
{
    public function let()
    {
        $number = '23A';
        $otherInfo = 'Block 5, ap 453';
        $this->beConstructedWith($number, $otherInfo);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(StreetInfo::class);
    }

    public function it_is_a_value_object()
    {
        $this->shouldHaveType(AggregateValueInterface::class);
    }

    public function it_can_be_transformed_into_an_array()
    {
        $array = $this->toArray();
        $array->shouldHaveKeyWithValue('street_number', '23A');
        $array->shouldHaveKeyWithValue('other_info', 'Block 5, ap 453');
    }

    public function it_can_be_transformed_into_a_string()
    {
        $this->shouldBeLike('23A, Block 5, ap 453');
    }

    public function it_can_have_only_the_number()
    {
        $this->beConstructedWith('35');
        $this->shouldBeLike('35');
    }

    public function it_the_street_number_have_a_max_length_of_10_characters()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['09876543210']);
    }

    public function it_the_other_info_have_a_max_length_of_100_characters()
    {
        $realyLongInfo = str_pad('', 101, 'a');
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['09', $realyLongInfo]);
    }
}
