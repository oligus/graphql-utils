<?php declare(strict_types=1);

namespace GraphQLUtils\Types\Scalars;

use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;
use Exception;

/**
 * Class Uuid
 * @package GraphQLUtils\Types\Scalars
 */
class UuidType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'UUID';

    /**
     * @var string
     */
    public $description = 'The `UUID` scalar type represents a universally unique identifier (UUID), according to RFC 4122.';

    /**
     * @param mixed $value
     * @throws InvariantViolation
     * @throws Error
     */
    public function serialize($value): string
    {
        $uuidStr = null;

        if ($value instanceof Uuid) {
            $uuidStr = $value->toString();
        }

        if (is_string($value)) {
            $uuidStr = $value;
        }

        if (!is_string($uuidStr)) {
            throw new InvariantViolation('UUID is not an instance type of UUID ' . Utils::printSafe($uuidStr));
        }

        if (!Uuid::isValid($uuidStr)) {
            throw new Error('Query error: Value is not a valid UUID string: ' . Utils::printSafe($uuidStr));
        }

        return $uuidStr;
    }

    /**
     * @param mixed $value
     * @throws Exception
     */
    public function parseValue($value): UuidInterface
    {
        if (!Uuid::isValid($value)) {
            throw new Error('Query error: Value is not a valid UUID string: ' . Utils::printSafe($value));
        }

        return Uuid::fromString($value);
    }

    /**
     * @param Node $valueNode
     * @param array<mixed>|null $variables
     * @throws Error
     * @throws Exception
     * @phan-suppress PhanUnusedPublicMethodParameter,PhanUndeclaredProperty
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function parseLiteral($valueNode, ?array $variables = null): UuidInterface
    {
        if (!$valueNode instanceof Node) {
            throw new Error('Query error: Unknown node type');
        }

        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }

        if (!Uuid::isValid($valueNode->value)) {
            throw new Error('Query error: Value is not a valid UUID string: ' . $valueNode->value, [$valueNode]);
        }

        return Uuid::fromString($valueNode->value);
    }
}
