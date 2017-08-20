<?php

namespace Infrastructure\DoctrineType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Model\Value\CPF;

class CPFType extends Type
{
    const CPF_TYPE = 'cpf'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $fieldDeclaration['length'] = 11;
        $fieldDeclaration['fixed'] = true;
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new CPF($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->toDigits();
    }

    public function getName()
    {
        return self::CPF_TYPE;
    }
}
