<?php

namespace Library\Factory;

use Library\Entity\EntityInterface;

interface EntityFactoryInterface
{
    public function createFromInput(array $input): EntityInterface;
}
