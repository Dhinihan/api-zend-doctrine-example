<?php

namespace Infrastructure\DoctrineType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid as ValueUuid;

class Uuid extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'uuid';
    }

    public function getName()
    {
        return 'uuid';
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return ValueUuid::fromString($value);
    }
}
