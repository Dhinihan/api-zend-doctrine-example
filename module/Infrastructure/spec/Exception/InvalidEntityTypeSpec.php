<?php

namespace spec\Infrastructure\Exception;

use Infrastructure\Exception\InvalidEntityType;
use PhpSpec\ObjectBehavior;

class InvalidEntityTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(InvalidEntityType::class);
    }

    public function it_is_an_exception()
    {
        $this->shouldHaveType(\Exception::class);
    }

    public function it_can_be_created_with_right_and_wrong_class()
    {
        $this->beConstructedThrough('fromRightAndWrongClass', ['Right', 'Wrong']);
        $this->getMessage()->shouldBeEqualTo('Entity was expected to be of type Right, but it is Wrong');
    }
}
