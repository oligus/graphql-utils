<?php declare(strict_types=1);

namespace GraphQLUtils\Helpers;

use DateTime;

/**
 * Class DateHelper
 * @package GraphQLUtils\Helpers
 */
class DateHelper
{
    public static function isValidDateString(string $dateString, string $format = 'Y-m-d'): bool
    {
        $date = DateTime::createFromFormat($format, $dateString);
        return $date && $date->format($format) === $dateString;
    }
}
