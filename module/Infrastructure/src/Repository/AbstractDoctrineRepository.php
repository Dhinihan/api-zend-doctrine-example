<?php

namespace Infrastructure\Repository;

use DoctrineModule\Paginator\Adapter\Selectable;
use Doctrine\ORM\EntityManager;
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
        try {
            $doctrineRepository = $this->em->getRepository($this->entityClass);
        } catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

        $adapter = new Selectable($doctrineRepository);
        return new Paginator($adapter);
    }
}
