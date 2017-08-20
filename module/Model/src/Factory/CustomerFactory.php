<?php

namespace Model\Factory;

use Assert\Assert;
use Assert\Assertion;
use Library\Entity\EntityInterface;
use Library\Factory\EntityFactoryInterface;
use Model\Entity\Customer;
use Model\Value\Name;
use Ramsey\Uuid\Uuid;

class CustomerFactory implements EntityFactoryInterface
{
    public function createFromInput(array $input): EntityInterface
    {
        Assertion::keyIsset($input, 'name');

        $name = new Name($input['name']);

        return new Customer(Uuid::uuid1(), $name);
    }
}
