<?php

namespace spec\Model\Value;

use Model\Value\CPF;
use Model\Value\ValueInterface;
use PhpSpec\ObjectBehavior;

class CPFSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('566.281.520-81');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CPF::class);
    }

    public function it_is_a_value()
    {
        $this->shouldHaveType(ValueInterface::class);
    }

    public function it_must_be_constructed_with_a_valid_cpf()
    {
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['111.222.333-44']);
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['111.222.333-94']);
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['555.555.555-55']);
    }

    public function it_must_have_the_right_format()
    {
        // $this->shouldThrow('InvalidArgumentException')->during('__construct', ['566-281-520-81']);
        $this->shouldThrow('InvalidArgumentException')->during('__construct', ['566281520810']);
    }

    public function it_accpets_only_digits()
    {
        $this->beConstructedWith('56628152081');
        $this->shouldBeLike('56628152081');
    }

    public function it_is_a_string()
    {
        $this->shouldBeLike('56628152081');
    }

    public function it_can_be_transformed_into_digits()
    {
        $this->toDigits()->shouldReturn('56628152081');
    }
}
