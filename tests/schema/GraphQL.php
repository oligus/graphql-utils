<?php declare(strict_types=1);

namespace Tests\Schema;

use GraphQL\GraphQL as GraphQLLib;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use Tests\Schema\Types\Query;
use Exception;

/**
 * Class GraphQL
 * @package Tests\Schema
 */
class GraphQL
{
    public static function query(string $query, ?array $variables = null)
    {
        $config = SchemaConfig::create();
        $config->setQuery(new Query());

        $schema = new Schema($config);

        try {
            $result = GraphQLLib::executeQuery($schema, $query, null, null, $variables);
            $output = $result->toArray(true);
        } catch (Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }

        return json_encode($output, JSON_PRETTY_PRINT);
    }
}
