<?php

namespace Model\Factory;

use Assert\Assertion;
use Library\Entity\EntityInterface;
use Library\Factory\EntityFactoryInterface;
use Model\Entity\Customer;
use Model\Value\CPF;
use Model\Value\Name;
use Ramsey\Uuid\Uuid;

class CustomerFactory implements EntityFactoryInterface
{
    public function createFromInput(array $input): EntityInterface
    {
        Assertion::keyIsset($input, 'name');
        Assertion::keyIsset($input, 'cpf');

        $name = new Name($input['name']);
        $cpf = new CPF($input['cpf']);

        return new Customer(Uuid::uuid1(), $name, $cpf);
    }
}
