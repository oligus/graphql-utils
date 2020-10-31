<?php declare(strict_types=1);

namespace Tests\SchemaTest;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Schema\GraphQL;

/**
 * Class MoneyTypeTest
 * @package Tests\SchemaTest
 */
class AmountTypeTest extends TestCase
{
    use MatchesSnapshots;

    public function testDate()
    {
        $query = '{ record { amount { sum currency formatted(locale:"sv_SE") } } }';
        $result = GraphQL::query($query);
        $this->assertMatchesJsonSnapshot($result);
    }
}
