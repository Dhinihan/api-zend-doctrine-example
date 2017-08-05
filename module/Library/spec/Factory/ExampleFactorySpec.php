<?php

namespace spec\Library\Factory;

use Library\Factory\ExampleFactory;
use PhpSpec\ObjectBehavior;

class ExampleFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ExampleFactory::class);
    }

    public function it_can_create_an_example_from_input()
    {
        $example = $this->createFromInput(['description' => 'A description']);
        $array = $example->toArray();
        $array['id']->shouldBeString();
        $array['description']->shouldBeEqualTo('A description');
    }
}
