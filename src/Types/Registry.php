<?php declare(strict_types=1);

namespace GraphQLUtils\Types;

use GraphQLUtils\Types\Scalars\DateType;

/**
 * Class Registry
 * @package GraphQLUtils\Types
 */
class Registry
{
    /**
     * @var DateType
     */
    private static $dateType;

    public static function date(string $format = 'Y-m-d'): DateType
    {
        return self::$dateType ? : (self::$dateType = new DateType([
            'format' => $format
        ]));
    }
}
