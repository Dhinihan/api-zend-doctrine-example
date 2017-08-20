<?php

namespace spec\Infrastructure\DoctrineType;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Infrastructure\DoctrineType\CPFType;
use Model\Value\CPF;
use PhpSpec\ObjectBehavior;

class CPFTypeSpec extends ObjectBehavior
{
    public function let()
    {
        if (!Type::hasType(CPFType::CPF_TYPE)) {
            Type::addType(CPFType::CPF_TYPE, CPFType::class);
        }
        $this->beConstructedThroughGetType(CPFType::CPF_TYPE);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CPFType::class);
    }

    public function it_is_a_doctrine_type()
    {
        $this->shouldHaveType(Type::class);
    }

    public function it_can_transform_to_php_value(AbstractPlatform $platform)
    {
        $phpValue = $this->convertToPHPValue('56628152081', $platform);
        $phpValue->shouldBeAnInstanceOf(CPF::class);
        $phpValue->shouldBeLike('56628152081');
    }

    public function it_can_transform_to_data_base_value(AbstractPlatform $platform, CPF $cpf)
    {
        $cpf->toDigits()->willReturn('56628152081');
        $databaseValue = $this->convertToDatabaseValue($cpf, $platform);
        $databaseValue->shouldBeLike('56628152081');
    }

    public function it_has_a_sql_declaration(AbstractPlatform $platform)
    {
        $platform->getVarcharTypeDeclarationSQL(['length' => 11, 'fixed' => true])->shouldBeCalled();
        $this->getSQLDeclaration([], $platform);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldReturn('cpf');
    }
}
