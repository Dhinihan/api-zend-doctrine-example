<?php

namespace Model\Value;

use Assert\Assertion;

class CPF implements ValueInterface
{
    private $value;

    public function __construct(string $cpf)
    {
        Assertion::regex($cpf, "/^((\d{11})|(\d{3}\.\d{3}\.\d{3}-\d{2}))$/");
        $cpf = preg_replace('/[^\d]/', '', $cpf);
        $this->valida($cpf);
        $this->value = $cpf;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function toDigits() : string
    {
        return $this->value;
    }

    private function valida(string $cpf)
    {
        $primeiroDigito = $cpf[9];
        $segundoDigito = $cpf[10];
        $digitosPrincipais = substr($cpf, 0, 9);

        $this->validaDigito($digitosPrincipais, $primeiroDigito);
        $this->validaDigito($digitosPrincipais . $primeiroDigito, $segundoDigito);
        $this->validaNaoRepetido($cpf);
    }

    private function validaDigito(string $digitosPrincipais, string $digitoVerificador)
    {
        $valor = 0;
        $tamanho = strlen($digitosPrincipais);
        foreach (str_split($digitosPrincipais) as $indice => $digito) {
            $valor += ($tamanho - $indice + 1) * $digito;
        }
        $valor = $valor * 10 % 11 % 10;
        if ($valor != $digitoVerificador) {
            throw new \InvalidArgumentException("CPF inválido", 500);
        }
    }

    private function validaNaoRepetido(string $digitos)
    {
        $invalido = true;
        $primeiroDigito = $digitos[0];
        foreach (str_split($digitos) as $digito) {
            $invalido = $invalido && $digito == $primeiroDigito;
        }
        if ($invalido) {
            throw new \InvalidArgumentException("CPF inválido", 500);
        }
    }
}
