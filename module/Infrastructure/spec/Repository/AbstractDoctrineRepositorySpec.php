<?php

namespace spec\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Infrastructure\Exception\EntityNotFoundException;
use Infrastructure\Exception\InvalidEntityType;
use Infrastructure\Repository\AbstractDoctrineRepository;
use Infrastructure\Repository\RepositoryInterface;
use Library\Entity\EntityInterface;
use PhpSpec\ObjectBehavior;
use Zend\Paginator\Paginator;

class AbstractDoctrineRepositorySpec extends ObjectBehavior
{
    private $em;

    public function let(EntityManager $em)
    {
        $this->beAnInstanceOf(DummyDoctrineRepository::class);
        $this->beConstructedWith($em, 'spec\Infrastructure\Repository\Entity');
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
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $this->generatePaginator()->shouldBeAnInstanceOf(Paginator::class);
    }

    public function it_can_find_an_entity(EntityRepository $repository, Entity $entity)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn($entity);
        $this->find(1)->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_returns_null_when_try_to_find_a_non_existing_entity(EntityRepository $repository)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn(null);
        $this->find(1)->shouldReturn(null);
    }

    public function it_can_get_an_entity(EntityRepository $repository, Entity $entity)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn($entity);
        $this->get(1)->shouldBeAnInstanceOf(Entity::class);
    }

    public function it_fails_when_try_to_get_non_existing_entity(EntityRepository $repository)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn(null);
        $this->shouldThrow(EntityNotFoundException::class)->during('get', [1]);
    }

    public function it_fails_when_entity_is_dont_implement_entity_interface(EntityRepository $repository, $entity)
    {
        try {
            $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
            $repository->find(1)->willReturn($entity);
            $this->get(1);
            throw new \Exception('oops you didn\'t throw the TypeError');
        } catch (\TypeError $e) {
        }
    }

    public function it_can_save_an_entity(Entity $entity)
    {
        $this->em->persist($entity)->shouldBeCalled();
        $this->em->flush()->shouldBeCalled();
        $this->save($entity);
    }

    public function it_cannot_save_another_entity(EntityInterface $entity)
    {
        $this->shouldThrow(InvalidEntityType::class)->during('save', [$entity]);
    }

    public function it_can_delete_an_entity(EntityRepository $repository, Entity $entity)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn($entity);

        $this->em->remove($entity)->shouldBeCalled();
        $this->em->flush()->shouldBeCalled();
        $this->delete(1);
    }

    public function it_cannot_delete_an_unexisting_entity(EntityRepository $repository)
    {
        $this->em->getRepository('spec\Infrastructure\Repository\Entity')->willReturn($repository);
        $repository->find(1)->willReturn(null);

        $this->shouldThrow(EntityNotFoundException::class)->during('delete', [1]);
    }
}


// @codingStandardsIgnoreStart
class DummyDoctrineRepository extends AbstractDoctrineRepository
{
}
// @codingStandardsIgnoreEnd

// @codingStandardsIgnoreStart
interface Entity extends EntityInterface
{
}
// @codingStandardsIgnoreEnd
