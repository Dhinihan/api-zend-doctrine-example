<?php

namespace Model\Value;

interface AggregateValueInterface extends ValueInterface
{
    public function toArray() : array;
}
