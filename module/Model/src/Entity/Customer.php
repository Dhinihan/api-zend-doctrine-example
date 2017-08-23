<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Library\Entity\EntityInterface;
use Model\Value\Address;
use Model\Value\CPF;
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
    /**
     * @ORM\Column(type="cpf")
     */
    private $cpf;

    /**
     * @ORM\Embedded(class = "Model\Value\Address", columnPrefix = false)
     */
    private $address;

    public function __construct(Uuid $id, Name $name, CPF $cpf)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->address = null;
    }

    public function toArray() : array
    {
        return [
            'name' => (string) $this->name,
            'cpf' => (string) $this->cpf,
            'id' => (string) $this->id,
            'address' => $this->address ? $this->address->toArray() : null
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

    public function receiveAddress(Address $address)
    {
        $this->address = $address;
    }
}
