<?php

namespace Model\Value;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class StreetInfo implements AggregateValueInterface
{
    /**
     * @ORM\Column(type = "string", length = 10, nullable = true)
     */
    protected $streetNumber;

    /**
     * @ORM\Column(name = "street_other_info", type = "string", length=100, nullable = true)
     */
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
