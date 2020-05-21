<?php declare(strict_types=1);

namespace Tests\Types\Scalars;

use Exception;
use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\StringValueNode;
use GraphQLUtils\Types\Scalars\MoneyType;
use Money\Money;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class MoneyTypeTest
 * @package Tests\Types\Scalars
 */
class MoneyTypeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSerialize()
    {
        $moneyType = new MoneyType();
        $money = Money::SEK('29900');
        $this->assertEquals('29900', $moneyType->serialize($money));
        $this->assertEquals('The `Money` scalar type represents the lowest denominator of a currency. Value here is a subunit that is a fraction of the main currency unit (base).', $moneyType->description);
    }

    /**
     * @throws Exception
     */
    public function testSerializeException()
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('Not an instance of Money (199)');
        $moneyType = new MoneyType();
        $moneyType->serialize(199);
    }

    /**
     * @throws Exception
     */
    public function testParseValue()
    {
        $moneyType = new MoneyType();
        $money = Money::SEK('19900');
        $this->assertEquals($money, $moneyType->parseValue('19900'));
    }

    /**
     * @throws Exception
     */
    public function testParseValueExceptionOnlyString()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse strings got: instance of stdClass');
        $moneyType = new MoneyType();
        $moneyType->parseValue(new stdClass());
    }

    /**
     * @throws Exception
     */
    public function testParseValueExceptionNonEmpty()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse non empty strings got: (empty string)');
        $moneyType = new MoneyType();
        $moneyType->parseValue('');
    }

    /**
     * @throws Error
     */
    public function testParseLiteral()
    {
        $moneyType = new MoneyType();
        $node = new StringValueNode(['value' => '19900']);
        $this->assertEquals(Money::SEK('19900'), $moneyType->parseLiteral($node));
    }

    /**
     * @throws Error
     */
    public function testParseLiteralExceptionUnknownNode()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Unknown node type');
        $moneyType = new MoneyType();
        $moneyType->parseLiteral(null);
    }

    /**
     * @throws Error
     */
    public function testParseLiteralExceptionString()
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Query error: Can only parse strings got: IntValue');
        $moneyType = new MoneyType();
        $moneyType->parseLiteral(new IntValueNode([]));
    }
}
