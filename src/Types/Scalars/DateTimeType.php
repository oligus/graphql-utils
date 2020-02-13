<?php declare(strict_types=1);

namespace GraphQLUtils\Types\Scalars;

use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use DateTime;
use DateTimeImmutable;

/**
 * Class DateTimeType
 * @package GraphQLUtils\Types\Scalars
 */
class DateTimeType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'DateTime';

    /**
     * @var string
     */
    public $description = 'The `DateTime` scalar type represents time data, represented as an ISO-8601 encoded UTC date string.';

    /**
     * @param mixed $value
     * @throws Error
     */
    public function serialize($value): string
    {
        if (!$value instanceof DateTime) {
            throw new Error('DateTime is not an instance of DateTime, ' . Utils::printSafe($value));
        }

        return $value->format(DateTime::ATOM);
    }

    /**
     * @param mixed $value
     * @throws Error
     */
    public function parseValue($value): DateTimeImmutable
    {
        $dateTime = DateTimeImmutable::createFromFormat(DateTime::ATOM, $value);

        if (!$dateTime) {
            throw new Error('Query error: Value is not a valid ATOM DateTime string (Y-m-d\TH:i:sP): ' . Utils::printSafe($value));
        }

        return $dateTime;
    }

    /**
     * @param Node $valueNode
     * @param array<mixed>|null $variables
     * @throws Error
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @phan-suppress PhanUnusedPublicMethodParameter, PhanUndeclaredProperty
     */
    public function parseLiteral($valueNode, ?array $variables = null): DateTimeImmutable
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }

        $dateTime = DateTimeImmutable::createFromFormat(DateTime::ATOM, $valueNode->value);

        if (!$dateTime) {
            throw new Error('Query error: Value is not a valid ATOM DateTime string (Y-m-d\TH:i:sP): ' . Utils::printSafe($valueNode->value));
        }

        return $dateTime;
    }
}
