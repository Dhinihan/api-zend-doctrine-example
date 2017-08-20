<?php

namespace Library\Entity;

use Doctrine\ORM\Mapping as ORM;
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

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $description;

    public function __construct(Uuid $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }


    public function toArray() : array
    {
        return [
            'id' => $this->id->toString(),
            'description' => $this->description
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function updateFromInput(array $input)
    {
        if (array_key_exists('description', $input)) {
            $this->description = $input['description'];
        }
    }
}
