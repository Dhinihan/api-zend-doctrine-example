<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Paginator\Adapter\Selectable;
use Infrastructure\Exception\EntityNotFoundException;
use Infrastructure\Exception\InvalidEntityType;
use Library\Entity\EntityInterface;
use Zend\Paginator\Paginator;

abstract class AbstractDoctrineRepository implements RepositoryInterface
{
    private $em;
    private $entityClass;

    public function __construct(EntityManager $em, string $entityClass)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
    }

    public function generatePaginator() : Paginator
    {
        $doctrineRepository = $this->em->getRepository($this->entityClass);
        $adapter = new Selectable($doctrineRepository);
        return new Paginator($adapter);
    }

    public function find($identifier)
    {
        $doctrineRepository = $this->em->getRepository($this->entityClass);
        return $doctrineRepository->find($identifier);
    }

    public function get($identifier) : EntityInterface
    {
        $doctrineRepository = $this->em->getRepository($this->entityClass);
        $entity = $doctrineRepository->find($identifier);
        if ($entity === null) {
            throw EntityNotFoundException::fromClassAndIdentifier($this->entityClass, $identifier);
        }
        return $entity;
    }

    public function save(EntityInterface $entity)
    {
        if (!($entity instanceof $this->entityClass)) {
            throw InvalidEntityType::fromRightAndWrongClass($this->entityClass, get_class($entity));
        }

        $this->em->persist($entity);
        $this->em->flush();
    }
}
