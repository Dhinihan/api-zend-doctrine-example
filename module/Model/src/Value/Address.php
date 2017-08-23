<?php

namespace Model\Value;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Address implements AggregateValueInterface
{
    /**
     * @ORM\Column(type = "string", length = 8, nullable = true, options = {"fixed":true})
     */
    protected $cep;

    /**
     * @ORM\Embedded(class = "Model\Value\StreetInfo", columnPrefix = false)
     */
    protected $streetInfo;

    public function __construct(CEP $cep, StreetInfo $streetInfo)
    {
        $this->cep = $cep;
        $this->streetInfo = $streetInfo;
    }

    public function __toString()
    {
        $info = $this->toArray();
        $text = [];
        foreach ($info as $key => $value) {
            $text[] = "$key: $value";
        }
        return implode(', ', $text);
    }

    public function toArray() : array
    {
        return [
            'cep' => (string) $this->cep,
            'street_info' => (string) $this->streetInfo
        ];
    }
}
