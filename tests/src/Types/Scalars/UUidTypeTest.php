<?php declare(strict_types=1);

namespace Tests\Types\Scalars;

use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Error\Error;
use GraphQLUtils\Types\Scalars\UuidType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Exception;

/**
 * Class UUidTypeTest
 * @package Tests\Types\Scalars
 */
class UUidTypeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSerialize()
    {
        $uuidType = new UuidType();
        $uuid = Uuid::fromString('1c77f1e0-cd4a-4600-b449-26724b3cf1e1');

        $this->assertEquals('1c77f1e0-cd4a-4600-b449-26724b3cf1e1', $uuidType->serialize($uuid));
        $this->assertEquals('The `UUID` scalar type represents a universally unique identifier (UUID), according to RFC 4122.', $uuidType->description);
    }

    /**
     * @throws Exception
     */
    public function testSerializeException()
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('Not an instance type of UUID (test)');
        $uuidType = new UuidType();
        $uuidType->serialize('test');
    }

    /**
     * @throws Exception
     */
    public function testParseValue()
    {
        $uuidType = new UuidType();
        $uuid = Uuid::fromString('1c77f1e0-cd4a-4600-b449-26724b3cf1e1');
        $this->assertEquals($uuid, $uuidType->parseValue($uuid->toString()));
    }

    /**
     * @throws Exception
     */
    public function testParseValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid UUID string: test');
        $uuidType = new UuidType();
        $uuidType->parseValue('test');
    }

    /**
     * @throws Error
     */
    public function testParseLiteral()
    {
        $uuidType = new UuidType();
        $node = new StringValueNode(['value' => '1c77f1e0-cd4a-4600-b449-26724b3cf1e1']);
        $this->assertEquals(Uuid::fromString('1c77f1e0-cd4a-4600-b449-26724b3cf1e1'), $uuidType->parseLiteral($node));
    }

    /**
     * @throws Error
     */
    public function testParseLiteralException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse strings got: IntValue');
        $uuidType = new UuidType();
        $uuidType->parseLiteral(new IntValueNode([]));
    }

    /**
     * @throws Error
     */
    public function testParseLiteralValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid UUID string: test');
        $uuidType = new UuidType();
        $uuidType->parseLiteral(new StringValueNode(['value' => 'test']));
    }
}
