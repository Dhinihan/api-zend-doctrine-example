<?php

namespace Infrastructure\Repository;

use DoctrineModule\Paginator\Adapter\Selectable;
use Doctrine\ORM\EntityManager;
use Library\Entity\EntityInterface;
use Infrastructure\Exception\EntityNotFoundException;
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
}
