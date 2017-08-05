<?php

namespace Library\Factory;

use Library\Entity\EntityInterface;
use Library\Entity\Example;
use Ramsey\Uuid\Uuid;

class ExampleFactory implements EntityFactoryInterface
{
    public function createFromInput(array $input): EntityInterface
    {
        $example = new Example(Uuid::uuid1(), $input['description']);
        return $example;
    }
}
