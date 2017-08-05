<?php

namespace spec\Application;

use Application\Module;
use PhpSpec\ObjectBehavior;

class ModuleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Module::class);
    }

    public function it_has_a_configuration()
    {
        $this->getConfig()->shouldBeArray();
    }
}
