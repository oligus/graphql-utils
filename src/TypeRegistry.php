<?php declare(strict_types=1);

namespace GraphQLUtils;

use Exception;
use GraphQL\Type\Definition;
use GraphQLUtils\Types\Objects\AmountType;
use GraphQLUtils\Types\Scalars\DateTimeType;
use GraphQLUtils\Types\Scalars\DateType;
use GraphQLUtils\Types\Scalars\MoneyType;
use GraphQLUtils\Types\Scalars\UuidType;

/**
 * Class TypeRegistry
 * @package GraphQLUtils
 * @phan-suppress PhanUnextractableAnnotation
 *
 * @method static self id
 * @method static self int
 * @method static self string
 * @method static self float
 * @method static self boolean
 *
 * @method static self listOf(self $type)
 * @method static self nonNull(self $type)
 *
 * @method static self date(?string $format = null)
 * @method static self dateTime
 * @method static self uuid
 * @method static self money
 * @method static self amount
 */
class TypeRegistry
{
    /**
     * @var array<Definition\Type>
     */
    private static $types = [];

    /**
     * @throws Exception
     */
    public static function get(string $key): Definition\Type
    {
        $key = strtolower($key);

        if (!array_key_exists($key, self::$types)) {
            throw new Exception('Unknown type: ' . $key);
        }

        return self::$types[$key];
    }

    /**
     * @throws Exception
     */
    public static function set(string $key, Definition\Type $type): void
    {
        if (array_key_exists($key, self::$types)) {
            throw new Exception('Type already registered: ' . $key);
        }

        self::$types[$key] = $type;
    }

    /**
     * @param array<mixed>|null $arguments
     * @throws Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function __callStatic(string $name, ?array $arguments = null): Definition\Type
    {
        $arg = null;

        if (!empty($arguments)) {
            $arg = $arguments[0];
        }

        if (array_key_exists($name, self::$types)) {
            return self::$types[$name];
        }

        switch ($name) {
            case 'id':
                self::$types[$name] = Definition\Type::id();
                break;
            case 'int':
                self::$types[$name] = Definition\Type::int();
                break;
            case 'string':
                self::$types[$name] = Definition\Type::string();
                break;
            case 'float':
                self::$types[$name] = Definition\Type::float();
                break;
            case 'boolean':
                self::$types[$name] = Definition\Type::boolean();
                break;
            case 'listOf':
                self::$types[$name] = new Definition\ListOfType($arg);
                break;
            case 'nonNull':
                self::$types[$name] = new Definition\NonNull($arg);
                break;
            case 'date':
                self::$types[$name] = new DateType(['format' => $arg]);
                break;
            case 'dateTime':
                self::$types[$name] = new DateTimeType();
                break;
            case 'uuid':
                self::$types[$name] = new UuidType();
                break;
            case 'money':
                self::$types[$name] = new MoneyType();
                break;
            case 'amount':
                self::$types[$name] = new AmountType();
                break;
            default:
                throw new Exception('Unknown type: ' . $name);
        }

        return self::$types[$name];
    }

    /**
     * Disabled intentionally
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @phan-suppress PhanEmptyPrivateMethod
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Disabled intentionally
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @phan-suppress PhanEmptyPrivateMethod
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * Disabled intentionally
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @phan-suppress PhanEmptyPrivateMethod
     * @codeCoverageIgnore
     */
    private function __wakeup()
    {
    }
}
