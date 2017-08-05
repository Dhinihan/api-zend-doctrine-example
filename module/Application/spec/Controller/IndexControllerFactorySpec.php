<?php

namespace spec\Application\Controller;

use Application\Controller\IndexController;
use Application\Controller\IndexControllerFactory;
use Interop\Container\ContainerInterface;
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

    public function it_build_a_index_controller(ContainerInterface $sl, ExampleRepository $repository)
    {
        $sl->get(ExampleRepository::class)->willReturn($repository);
        $this($sl, IndexController::class)->shouldBeAnInstanceOf(IndexController::class);
    }
}
