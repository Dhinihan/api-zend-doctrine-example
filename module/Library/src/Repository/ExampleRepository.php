<?php

namespace Library\Repository;

use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\AbstractDoctrineRepository;
use Library\Entity\Example;

class ExampleRepository extends AbstractDoctrineRepository
{
    public function __construct(EntityManager $em)
    {
        return parent::__construct($em, Example::class);
    }
}
