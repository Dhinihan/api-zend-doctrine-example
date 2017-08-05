<?php

namespace Infrastructure\Repository;

use Library\Entity\EntityInterface;
use Zend\Paginator\Paginator;

interface RepositoryInterface
{
    public function generatePaginator() : Paginator;

    public function find($identifier);

    public function get($identifier) : EntityInterface;

    public function save(EntityInterface $entity);
}
