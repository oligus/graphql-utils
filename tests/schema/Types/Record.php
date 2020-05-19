<?php declare(strict_types=1);

namespace Tests\Schema\Types;

use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQLUtils\TypeRegistry;

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
                    'id' => TypeRegistry::id(),
                    'name' => TypeRegistry::string(),
                    'date' => TypeRegistry::date(),
                    'dateFormat' => TypeRegistry::date('d/m/Y'),
                    'dateTime' => TypeRegistry::dateTime(),
                    'uuid' => TypeRegistry::uuid(),
                ];
            }
        ];

        parent::__construct($config);
    }
}
