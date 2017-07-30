<?php

namespace spec\Infrastructure\Rest;

use Infrastructure\Rest\JsonError;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonError::class);
    }
}
