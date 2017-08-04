<?php

namespace spec\Library\Repository;

use Library\Repository\ExampleRepository;
use Library\Repository\ExampleRepositoryFactory;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\ServiceManager\Factory\FactoryInterface;

class ExampleRepositoryFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ExampleRepositoryFactory::class);
    }

    public function it_is_a_factory()
    {
        $this->shouldBeAnInstanceOf(FactoryInterface::class);
    }

    public function it_build_a_repository(ContainerInterface $sl, EntityManager $em)
    {
        $sl->get(EntityManager::class)->willReturn($em);
        $this($sl, ExampleRepository::class)->shouldBeAnInstanceOf(ExampleRepository::class);
    }
}
