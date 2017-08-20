<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Model\Entity\Customer;

class CustomerRepository extends AbstractDoctrineRepository
{
    public function __construct(EntityManager $em)
    {
        return parent::__construct($em, Customer::class);
    }
}
