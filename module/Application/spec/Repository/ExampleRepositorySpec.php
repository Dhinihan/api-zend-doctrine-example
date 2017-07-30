<?php

namespace spec\Application\Repository;

use Application\Repository\ExampleRepository;
use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleRepositorySpec extends ObjectBehavior
{
    public function let(EntityManager $em)
    {
        $this->beConstructedWith($em);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ExampleRepository::class);
    }

    public function it_is_a_repository()
    {
        $this->shouldHaveType(RepositoryInterface::class);
    }
}
