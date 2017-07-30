<?php

namespace Application\Repository;

use Application\Entity\Example;
use Doctrine\ORM\EntityManager;
use Infrastructure\Repository\AbstractDoctrineRepository;

class ExampleRepository extends AbstractDoctrineRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, Example::class);
    }
}
