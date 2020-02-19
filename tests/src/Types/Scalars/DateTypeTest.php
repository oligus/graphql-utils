<?php declare(strict_types=1);

namespace Tests\Types\Scalars;

use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\StringValueNode;
use GraphQLUtils\Types\Scalars\DateType;
use GraphQL\Error\Error;
use PHPUnit\Framework\TestCase;
use DateTime;
use stdClass;
use Exception;

/**
 * Class DateTypeTest
 * @package Tests\Types\Scalars
 */
class DateTypeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSerialize()
    {
        $date = new DateType();
        $inputDate = new DateTime('2020-02-11');
        $this->assertEquals('2020-02-11', $date->serialize($inputDate));
        $this->assertEquals('The `Date` scalar type represents date in format "Y-m-d"', $date->description);
    }

    /**
     * @throws Exception
     */
    public function testSerializeFormat()
    {
        $date = new DateType(['format' => 'm/d/Y']);
        $inputDate = new DateTime('02/11/2020');
        $this->assertEquals('02/11/2020', $date->serialize($inputDate));
        $this->assertEquals('The `Date` scalar type represents date in format "m/d/Y"', $date->description);
    }

    /**
     * @throws Exception
     */
    public function testSerializeException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Date is not an instance of DateTime, instance of stdClass');
        $date = new DateType();
        $date->serialize(new stdClass());
    }

    /**
     * @throws Error
     */
    public function testParseValue()
    {
        $date = new DateType();
        $inputDate = new DateTime('2020-02-11');
        $this->assertEquals($inputDate, $date->parseValue('2020-02-11'));
    }

    /**
     * @throws Error
     */
    public function testParseValueFormat()
    {
        $date = new DateType(['format' => 'm/d/Y']);
        $inputDate = new DateTime('2020-02-11');
        $this->assertEquals($inputDate, $date->parseValue('02/11/2020'));
    }

    /**
     * @throws Error
     */
    public function testParseValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid Date string (Y-m-d): 2020-14-99');
        $date = new DateType();
        $date->parseValue('2020-14-99');
    }

    /**
     * @throws Error
     */
    public function testParseLiteral()
    {
        $date = new DateType();
        $node = new StringValueNode(['value' => '2019-01-01']);
        $this->assertEquals(new DateTime('2019-01-01'), $date->parseLiteral($node));
        $date->parseLiteral($node);
    }

    /**
     * @throws Error
     */
    public function testParseLiteralFormat()
    {
        $date = new DateType(['format' => 'm/d/Y']);
        $node = new StringValueNode(['value' => '01/02/2020']);
        $this->assertEquals(new DateTime('2020-01-02'), $date->parseLiteral($node));
        $date->parseLiteral($node);
    }

    /**
     * @throws Error
     */
    public function testParseLiteralException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse strings got: IntValue');
        $date = new DateType();
        $date->parseLiteral(new IntValueNode([]));
    }

    /**
     * @throws Error
     */
    public function testParseLiteralValueException()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Value is not a valid Date string (YYYY-mm-dd)');
        $date = new DateType();
        $date->parseLiteral(new StringValueNode(['value' => 'test']));
    }
}
