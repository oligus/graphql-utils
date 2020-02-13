<?php declare(strict_types=1);

namespace GraphQLUtils\Helpers;

/**
 * Class DateHelper
 * @package GraphQLUtils\Helpers
 */
class DateHelper
{
    public static function isValidDateString(string $date): bool
    {
        $result = preg_split('/-/', $date);

        if (count($result) !== 3) {
            return false;
        }

        $year = (int)$result[0];
        $month = (int)$result[1];
        $day = (int)$result[2];

        return checkdate($month, $day, $year);
    }
}
