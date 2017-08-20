<?php

namespace Model\Value;

class Address implements AggregateValueInterface
{
    protected $cep;
    protected $streetInfo;

    public function __construct(CEP $cep, $streetInfo)
    {
        $this->cep = $cep;
        $this->streetInfo = $streetInfo;
    }

    public function __toString()
    {
        throw new \Exception('Method not implemented');
    }

    public function toArray() : array
    {
        return [
            'cep' => (string) $this->cep,
            'street_info' => (string) $this->streetInfo
        ];
    }
}
