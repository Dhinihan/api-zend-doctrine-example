<?php

namespace spec\Infrastructure\Exception;

use Infrastructure\Exception\EntityNotFoundException;
use PhpSpec\ObjectBehavior;

class EntityNotFoundExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(EntityNotFoundException::class);
    }

    public function it_is_an_exception()
    {
        $this->shouldBeAnInstanceOf(\Exception::class);
    }

    public function it_can_be_created_with_default_message()
    {
        $this->beConstructedThrough('fromClassAndIdentifier', ['Entidade', 1]);
        $this->getMessage()->shouldReturn('Entity of class Entidade with id 1 could not be found');
        $this->getCode()->shouldReturn(404);
    }
}
