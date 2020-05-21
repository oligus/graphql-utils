<?php declare(strict_types=1);

namespace Tests\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use DateTime;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class Query
 * @package Tests\Schema
 */
class Query extends ObjectType
{
    /**
     * QueryType constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'description' => 'Test queries',

            'fields' => function (): array {
                return [
                    'record' => [
                        'type' => new Record(),
                         'resolve' => function () {
                            return [
                                'id' => 1,
                                'name' => 'Alfred',
                                'date' => new DateTime('2020-04-15'),
                                'dateFormat' => new DateTime('2020-01-05'),
                                'dateTime' => new DateTime('2020-01-12 14:15:00'),
                                'uuid' => Uuid::fromString('1c77f1e0-cd4a-4600-b449-26724b3cf1e1'),
                                'money' => Money::SEK('19900')
                            ];
                         }
                    ]
                ];
            }
        ]);
    }
}
