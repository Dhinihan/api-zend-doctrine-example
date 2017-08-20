<?php

namespace Model\Value;

use Assert\Assertion;

class StreetInfo implements AggregateValueInterface
{
    protected $streetNumber;
    protected $otherInfo;

    public function __construct(string $streetNumber, string $otherInfo = null)
    {
        Assertion::maxLength($streetNumber, 10);
        Assertion::nullOrMaxLength($otherInfo, 100);

        $this->streetNumber = $streetNumber;
        $this->otherInfo = $otherInfo;
    }

    public function __toString()
    {
        $text = $this->streetNumber;
        $text .= $this->otherInfo ? ', ' . $this->otherInfo : '';
        return $text;
    }

    public function toArray() : array
    {
        return [
            'street_number' => $this->streetNumber,
            'other_info' => $this->otherInfo
        ];
    }
}
