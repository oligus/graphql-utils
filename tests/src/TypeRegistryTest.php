<?php declare(strict_types=1);

namespace Tests;

use GraphQL\Type\Definition;
use PHPUnit\Framework\TestCase;
use GraphQLUtils\TypeRegistry;
use GraphQLUtils\Types;
use Exception;

/**
 * Class TypeRegistryTest
 * @package Tests\SchemaTest
 */
class TypeRegistryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testMoney()
    {
        $moneyType = TypeRegistry::money();
        $this->assertInstanceOf(Types\Scalars\MoneyType::class, $moneyType);
        $this->assertInstanceOf(Types\Scalars\MoneyType::class, TypeRegistry::get('money'));
    }

    public function testDateTime()
    {
        $dateTimeType = TypeRegistry::dateTime();
        $this->assertInstanceOf(Types\Scalars\DateTimeType::class, $dateTimeType);
    }

    public function testDate()
    {
        $dateType =  TypeRegistry::date('Y-m-d');
        $this->assertInstanceOf(Types\Scalars\DateType::class, $dateType);
    }

    public function testArguments()
    {
        $this->assertInstanceOf(Definition\ListOfType::class, TypeRegistry::listOf(TypeRegistry::id()));
        $this->assertInstanceOf(Definition\NonNull::class, TypeRegistry::nonNull(TypeRegistry::id()));
    }

    /**
     * @throws Exception
     */
    public function testGetStandardTypes()
    {
        $this->assertInstanceOf(Definition\IDType::class, TypeRegistry::id());
        $this->assertInstanceOf(Definition\IntType::class, TypeRegistry::int());
        $this->assertInstanceOf(Definition\StringType::class, TypeRegistry::string());
        $this->assertInstanceOf(Definition\FloatType::class, TypeRegistry::float());
        $this->assertInstanceOf(Definition\BooleanType::class, TypeRegistry::boolean());
    }

    /**
     * @throws Exception
     */
    public function testUnknown()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown type: unknown');
        TypeRegistry::get('unknown');
    }

    public function testGetException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unknown type: test');
        TypeRegistry::get('test');
    }

    /**
     * @throws Exception
     */
    public function testSet()
    {
        TypeRegistry::set('test', new Types\Scalars\MoneyType());
        $this->assertInstanceOf(Types\Scalars\MoneyType::class, TypeRegistry::get('test'));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Type already registered: test');
        TypeRegistry::set('test', new Types\Scalars\MoneyType());
    }

}
