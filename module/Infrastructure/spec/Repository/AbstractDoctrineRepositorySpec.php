<?php

namespace spec\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Infrastructure\Repository\AbstractDoctrineRepository;
use Infrastructure\Repository\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Zend\Paginator\Paginator;

class AbstractDoctrineRepositorySpec extends ObjectBehavior
{
    private $em;

    public function let(EntityManager $em)
    {
        $this->beAnInstanceOf(DummyDoctrineRepository::class);
        $this->beConstructedWith($em, 'Entidade');
        $this->em = $em;
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(AbstractDoctrineRepository::class);
    }

    public function it_is_a_repository()
    {
        $this->shouldBeAnInstanceOf(RepositoryInterface::class);
    }

    public function it_can_produce_a_paginator(EntityRepository $repository)
    {
        $this->em->getRepository('Entidade')->willReturn($repository);
        $this->generatePaginator()->shouldBeAnInstanceOf(Paginator::class);
    }
}


// @codingStandardsIgnoreStart
class DummyDoctrineRepository extends AbstractDoctrineRepository
{
}
// @codingStandardsIgnoreEnd

