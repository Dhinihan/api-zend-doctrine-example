<?php

namespace Model\Value;

use Assert\Assertion;

class CEP implements ValueInterface
{
    private $cep;

    public function __construct(string $cep)
    {
        Assertion::regex($cep, '/^((\d{8})|(\d{5}-\d{3}))$/');
        $cep = preg_replace('/-/', '', $cep);
        $this->cep = $cep;
    }

    public function __toString()
    {
        return $this->cep;
    }
}
