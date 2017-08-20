<?php

namespace Model\Value;

use Assert\Assertion;

class Name implements ValueInterface
{
    protected $value;

    public function __construct(string $name)
    {
        Assertion::maxLength($name, 60);
        $this->value = $name;
    }

    public function __toString()
    {
        return $this->value;
    }
}
