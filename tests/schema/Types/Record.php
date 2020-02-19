<?php declare(strict_types=1);

namespace Tests\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQLUtils\Types\Registry;
use GraphQLUtils\Types\Scalars\DateTimeType;
use Exception;

/**
 * Class Ado
 * @package Tests\Schema\Types
 */
class Record extends ObjectType
{
    /**
     * Ado constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Record',
            'description' => 'Record',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'id' => Type::id(),
                    'name' => Type::string(),
                    'date' => Registry::date(),
                    'dateFormat' => Registry::date('d/m/Y'),
                    'dateTime' => new DateTimeType(),

                ];
            }
        ];

        parent::__construct($config);
    }
}
