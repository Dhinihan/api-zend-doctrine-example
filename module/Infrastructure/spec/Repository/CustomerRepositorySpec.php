<?php

namespace spec\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\AbstractDoctrineRepository;
use Infrastructure\Repository\CustomerRepository;
use PhpSpec\ObjectBehavior;

class CustomerRepositorySpec extends ObjectBehavior
{
    private $em;

    public function let(EntityManager $em)
    {
        $this->em = $em;
        $this->beConstructedWith($em);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomerRepository::class);
    }

    public function it_is_a_doctrine_repository()
    {
        $this->shouldHaveType(AbstractDoctrineRepository::class);
    }
}
