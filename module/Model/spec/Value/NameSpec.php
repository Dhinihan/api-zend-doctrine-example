<?php

namespace spec\Model\Value;

use Model\Value\Name;
use Model\Value\ValueInterface;
use PhpSpec\ObjectBehavior;

class NameSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith("John Doe");
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Name::class);
    }

    public function it_is_a_value()
    {
        $this->shouldHaveType(ValueInterface::class);
    }

    public function it_is_a_string()
    {
        $this->shouldBeLike('John Doe');
    }

    public function it_cannot_have_more_than_60_characters()
    {
        $longName = 'Too long to be a proper name, don\'t you think? I certainly do!';
        $exception = 'Assert\InvalidArgumentException';
        $this->shouldThrow($exception)->during('__construct', [$longName]);
    }
}
