<?php

namespace spec\Model\Factory;

use Assert\InvalidArgumentException;
use Library\Factory\EntityFactoryInterface;
use Model\Entity\Customer;
use Model\Factory\CustomerFactory;
use PhpSpec\ObjectBehavior;

class CustomerFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomerFactory::class);
    }

    public function it_is_an_entity_factory()
    {
        $this->shouldHaveType(EntityFactoryInterface::class);
    }

    public function it_can_build_a_customer_from_input()
    {
        $this->createFromInput([
            'name' => 'George the customer',
            'cpf' => '057.748.194-00'
        ])->shouldHaveType(Customer::class);
    }

    public function it_cannont_build_a_customer_from_input_without_a_name()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('createFromInput', [[]]);
    }
}
