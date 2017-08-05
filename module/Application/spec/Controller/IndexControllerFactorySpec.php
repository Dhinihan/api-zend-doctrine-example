<?php

namespace spec\Application\Controller;

use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Interop\Container\ContainerInterface;
use Library\Factory\ExampleFactory;
use Library\Repository\ExampleRepository;
use PhpSpec\ObjectBehavior;

class IndexControllerFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(IndexControllerFactory::class);
    }

    public function it_is_a_factory()
    {
        $this->shouldBeAnInstanceOf(\Zend\ServiceManager\Factory\FactoryInterface::class);
    }

    public function it_build_a_index_controller(
        ContainerInterface $sl,
        ExampleRepository $repository,
        ExampleFactory $factory
    ) {
        $sl->get(ExampleRepository::class)->willReturn($repository);
        $sl->get(ExampleFactory::class)->willReturn($factory);
        $this($sl, IndexController::class)->shouldBeAnInstanceOf(IndexController::class);
    }
}
