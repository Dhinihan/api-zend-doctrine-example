<?php

namespace spec\Model\Value;

use Model\Value\CEP;
use Model\Value\ValueInterface;
use PhpSpec\ObjectBehavior;

class CEPSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('12345678');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CEP::class);
    }

    public function it_is_a_value_object()
    {
        $this->shouldHaveType(ValueInterface::class);
    }

    public function it_is_a_string()
    {
        $this->shouldBeLike('12345678');
    }

    public function it_can_be_constructed_with_a_dash()
    {
        $this->beConstructedWith('12345-678');
        $this->shouldBeLike('12345678');
    }

    public function it_must_be_in_the_right_format()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['1234-5678']);
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['123456789']);
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['123456']);
    }
}
