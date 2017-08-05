<?php

namespace spec\Library\Entity;

use Library\Entity\Example;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class ExampleSpec extends ObjectBehavior
{
    private $id;

    public function let()
    {
        $this->id = Uuid::uuid1();
        $this->beConstructedWith($this->id);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Example::class);
    }

    public function it_can_be_an_array()
    {
        $this->toArray()->shouldHaveKeyWithValue('id', $this->id->toString());
    }

    public function it_can_be_json_serialized()
    {
        $this->jsonSerialize()->shouldHaveKeyWithValue('id', $this->id->toString());
    }
}
