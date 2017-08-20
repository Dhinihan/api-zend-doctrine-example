<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Library\Entity\EntityInterface;
use Model\Value\Name;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class Customer implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    public function __construct(Uuid $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function toArray() : array
    {
        return [
            'name' => (string) $this->name,
            'id' => (string) $this->id
        ];
    }

    public function updateFromInput(array $input)
    {
        throw new \Exception("Invalid command", 405);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function name()
    {
        return $this->name;
    }
}
