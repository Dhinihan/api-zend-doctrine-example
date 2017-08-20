<?php

namespace spec\Model\Entity;

use Library\Entity\EntityInterface;
use Model\Entity\Customer;
use Model\Value\Address;
use Model\Value\CPF;
use Model\Value\Name;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class CustomerSpec extends ObjectBehavior
{
    protected $name;
    protected $cpf;

    public function let(Name $name, CPF $cpf)
    {
        $name->__toString()->willReturn('John Doe');
        $cpf->__toString()->willReturn('057.748.194-00');
        $this->name = $name;
        $this->cpf = $cpf;
        $this->beConstructedWith(Uuid::fromString('07b7423c-7a46-11e7-bb31-be2e44b06b34'), $name, $cpf);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Customer::class);
    }

    public function it_is_an_entity()
    {
        $this->shouldHaveType(EntityInterface::class);
    }

    public function it_has_a_name()
    {
        $name = $this->name();
        $name->shouldBe($this->name);
    }

    public function it_can_be_an_array()
    {
        $array = $this->jsonSerialize();
        $array->shouldHaveKeyWithValue('id', '07b7423c-7a46-11e7-bb31-be2e44b06b34');
        $array->shouldHaveKeyWithValue('name', 'John Doe');
        $array->shouldHaveKeyWithValue('cpf', '057.748.194-00');
    }

    public function it_can_receive_an_address(Address $address)
    {
        $addressArray = [
            'cep' => '12345678',
            'street_info' => '637, Block A',
        ];
        $address->toArray()->willReturn($addressArray);
        $this->receiveAddress($address);
        $this->toArray()->shouldHaveKeyWithValue('address', $addressArray);
    }

    public function it_cannot_be_changed_by_input()
    {
        $this->shouldThrow(new \Exception("Invalid command", 405))->duringUpdateFromInput([]);
    }
}
