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
        $this->beConstructedWith($this->id, 'A Description');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Example::class);
    }

    public function it_can_be_an_array()
    {
        $array = $this->toArray();
        $array->shouldHaveKeyWithValue('id', $this->id->toString());
        $array->shouldHaveKeyWithValue('description', 'A Description');
    }

    public function it_can_be_json_serialized()
    {
        $array = $this->jsonSerialize();
        $array->shouldHaveKeyWithValue('id', $this->id->toString());
        $array->shouldHaveKeyWithValue('description', 'A Description');
    }
}
