<?php declare(strict_types=1);

namespace Tests\Helpers;

use GraphQLUtils\Helpers\DateHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class DateHelperTest
 * @package Tests\Helpers
 */
class DateHelperTest extends TestCase
{
    public function testIsValidDate()
    {
        $this->assertFalse(DateHelper::isValidDateString('sdf sdf sd'));
        $this->assertFalse(DateHelper::isValidDateString('sdf-er'));
        $this->assertFalse(DateHelper::isValidDateString('sdf-er-wer'));
        $this->assertTrue(DateHelper::isValidDateString('2016-01-31'));
        $this->assertFalse(DateHelper::isValidDateString('2016-02-31'));
        $this->assertFalse(DateHelper::isValidDateString('2016-99-31'));
        $this->assertFalse(DateHelper::isValidDateString('2016-99-31'));
    }
}
