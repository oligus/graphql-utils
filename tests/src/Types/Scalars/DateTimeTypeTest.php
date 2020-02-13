<?php declare(strict_types=1);

namespace Tests\Types\Scalars;

use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\StringValueNode;
use GraphQLUtils\Types\Scalars\DateTimeType;
use GraphQL\Error\Error;
use PHPUnit\Framework\TestCase;
use DateTime;
use DateTimeImmutable;
use stdClass;
use Exception;

/**
 * Class DateTimeTypeTest
 * @package Tests\Types\Scalars
 */
class DateTimeTypeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSerialize()
    {
        $dateTime = new DateTimeType();
        $inputDate = new DateTime('2020-02-11T12:14:56+00:00');
        $this->assertEquals('2020-02-11T12:14:56+00:00', $dateTime->serialize($inputDate));
    }

    /**
     * @throws Exception
     */
    public function testSerializeException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('DateTime is not an instance of DateTime, instance of stdClass');
        $date = new DateTimeType();
        $date->serialize(new stdClass());
    }

    /**
     * @throws Exception
     */
    public function testParseValue()
    {
        $date = new DateTimeType();
        $inputDate = new DateTimeImmutable('2020-02-11T12:14:56+00:00');
        $this->assertEquals($inputDate, $date->parseValue('2020-02-11T12:14:56+00:00'));
    }

    /**
     * @throws Error
     */
    public function testParseValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid ATOM DateTime string (Y-m-d\TH:i:sP): 2020-14-99');
        $date = new DateTimeType();
        $date->parseValue('2020-14-99');
    }

    /**
     * @throws Error
     */
    public function testParseLiteral()
    {
        $date = new DateTimeType();
        $node = new StringValueNode(['value' => '2020-02-11T12:14:56+00:00']);

        $this->assertEquals(new DateTime('2020-02-11T12:14:56+00:00'), $date->parseLiteral($node));
        $date->parseLiteral($node);
    }

    /**
     * @throws Error
     */
    public function testParseLiteralException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse strings got: IntValue');
        $date = new DateTimeType();
        $date->parseLiteral(new IntValueNode([]));
    }

    /**
     * @throws Error
     */
    public function testParseLiteralValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid ATOM DateTime string (Y-m-d\TH:i:sP): test');
        $date = new DateTimeType();
        $date->parseLiteral(new StringValueNode(['value' => 'test']));
    }
}
