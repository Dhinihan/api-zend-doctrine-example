<?php

namespace Library\Entity;

use Doctrine\ORM\Mapping as ORM;
use Library\Entity\EntityInterface;
use Ramsey\Uuid\Uuid;
use Zend\Stdlib\JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="example")
 */
class Example implements JsonSerializable, EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }


    public function toArray() : array
    {
        return ['id' => $this->id->toString()];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
