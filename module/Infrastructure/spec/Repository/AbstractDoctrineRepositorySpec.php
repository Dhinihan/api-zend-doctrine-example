<?php

namespace spec\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Library\Entity\EntityInterface;
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

    public function it_can_find_an_entity(EntityRepository $repository, EntityInterface $entity)
    {
        $this->em->getRepository('Entidade')->willReturn($repository);
        $repository->find(1)->willReturn($entity);
        $this->find(1)->shouldBeAnInstanceOf(EntityInterface::class);
    }

    public function it_returns_null_when_try_to_find_a_non_existing_entity(EntityRepository $repository)
    {
        $this->em->getRepository('Entidade')->willReturn($repository);
        $repository->find(1)->willReturn(null);
        $this->find(1)->shouldReturn(null);
    }

    public function it_can_get_an_entity(EntityRepository $repository, EntityInterface $entity)
    {
        $this->em->getRepository('Entidade')->willReturn($repository);
        $repository->find(1)->willReturn($entity);
        $this->get(1)->shouldBeAnInstanceOf(EntityInterface::class);
    }

    public function it_fails_when_try_to_get_non_existing_entity(EntityRepository $repository)
    {
        $this->em->getRepository('Entidade')->willReturn($repository);
        $repository->find(1)->willReturn(null);
        $this->shouldThrow(\Infrastructure\Exception\EntityNotFoundException::class)->during('get', [1]);
    }

    public function it_fails_when_entity_is_dont_implement_entity_interface(EntityRepository $repository, $entity)
    {
        try {
            $this->em->getRepository('Entidade')->willReturn($repository);
            $repository->find(1)->willReturn($entity);
            $this->get(1);
            throw new \Exception('oops you didn\'t throw the TypeError');
        } catch (\TypeError $e) {
        }
    }
}


// @codingStandardsIgnoreStart
class DummyDoctrineRepository extends AbstractDoctrineRepository
{
}
// @codingStandardsIgnoreEnd
