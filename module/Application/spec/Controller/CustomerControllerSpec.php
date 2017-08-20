<?php

namespace spec\Application\Controller;

use Application\Controller\AbstractCrudController;
use Application\Controller\CustomerController;
use Infrastructure\Repository\CustomerRepository;
use Library\Factory\EntityFactoryInterface;
use PhpSpec\ObjectBehavior;

class CustomerControllerSpec extends ObjectBehavior
{
    public function let(CustomerRepository $repository, EntityFactoryInterface $factory)
    {
        $this->beConstructedWith($repository, $factory);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomerController::class);
    }

    public function it_is_a_crud_controller()
    {
        $this->shouldHaveType(AbstractCrudController::class);
    }
}
