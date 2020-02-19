<?php declare(strict_types=1);

namespace GraphQLUtils\Types\Scalars;

use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQLUtils\Helpers\DateHelper;
use DateTime;
use Exception;

/**
 * Class DateType
 * @package GraphQLUtils\Types\Scalars
 */
class DateType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'Date';

    /**
     * @var string
     */
    public $description = 'The `Date` scalar type represents date in format "Y-m-d"';

    /**
     * @var string
     */
    private $format = 'Y-m-d';

    /**
     * DateType constructor.
     * @param array<string,string> $config
     */
    public function __construct(array $config = [])
    {
        $this->format = $config['format'] ?? 'Y-m-d';
        $this->description = 'The `Date` scalar type represents date in format "' . $this->format . '"';

        parent::__construct($config);
    }

    /**
     * @param mixed $value
     * @throws Error
     */
    public function serialize($value): string
    {
        if (!$value instanceof DateTime) {
            throw new Error('Date is not an instance of DateTime, ' . Utils::printSafe($value));
        }

        return $value->format($this->format);
    }

    /**
     * @param mixed $value
     * @throws Error
     * @throws Exception
     */
    public function parseValue($value): DateTime
    {
        if (!DateHelper::isValidDateString($value, $this->format)) {
            throw new Error('Query error: Value is not a valid Date string (' . $this->format . '): ' . Utils::printSafe($value));
        }

        return new DateTime($value);
    }

    /**
     * @param Node $valueNode
     * @param array<mixed>|null $variables
     * @throws Error
     * @throws Exception
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @phan-suppress PhanUnusedPublicMethodParameter, PhanUndeclaredProperty
     */
    public function parseLiteral($valueNode, ?array $variables = null): DateTime
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }

        if (!DateHelper::isValidDateString($valueNode->value, $this->format)) {
            throw new Error('Query error: Value is not a valid Date string (' . $this->format . '): ' . $valueNode->kind, [$valueNode]);
        }

        return new DateTime($valueNode->value);
    }
}
