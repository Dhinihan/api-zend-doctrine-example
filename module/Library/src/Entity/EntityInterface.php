<?php

namespace Library\Entity;

use Zend\Stdlib\JsonSerializable;

interface EntityInterface extends JsonSerializable
{
    public function toArray() : array;

    public function updateFromInput(array $input);
}
