<?php

namespace spec\Infrastructure\DoctrineType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Infrastructure\DoctrineType\Uuid;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid as ValueUuid;

class UuidSpec extends ObjectBehavior
{
    public function let()
    {
        if (!Type::hasType('uuid')) {
            Type::addType('uuid', Uuid::class);
        }
        $this->beConstructedThrough('getType', array('uuid'));
    }


    public function it_is_initializable()
    {
        $this->shouldHaveType(Uuid::class);
    }

    public function it_is_a_doctrine_type()
    {
        $this->shouldBeAnInstanceOf(\Doctrine\DBAL\Types\Type::class);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBeEqualTo('uuid');
    }

    public function it_has_a_sql_name(AbstractPlatform $platform)
    {
        $this->getSqlDeclaration(array(), $platform)->shouldBeEqualTo('uuid');
    }

    public function it_is_a_string_to_save_in_the_database(AbstractPlatform $platform)
    {
        $uuid = '4b6771b8-74ca-11e7-b5a5-be2e44b06b34';
        $this->convertToDatabaseValue(ValueUuid::fromString($uuid), $platform)->shouldBeEqualTo($uuid);
    }

    public function it_is_a_uuid_when_revored_from_database(AbstractPlatform $platform)
    {
        $uuid = '4b6771b8-74ca-11e7-b5a5-be2e44b06b34';
        $this->convertToPHPValue('4b6771b8-74ca-11e7-b5a5-be2e44b06b34', $platform)->shouldBeAnInstanceOf(ValueUuid::class);
    }
}
