<?php declare(strict_types=1);

namespace Tests\SchemaTest;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Schema\GraphQL;

/**
 * Class DateTypeTest
 * @package Tests\SchemaTest
 */
class DateTypeTest extends TestCase
{
    use MatchesSnapshots;

    public function testDate()
    {
        $query = '{ record { date } }';
        $result = GraphQL::query($query);
        $this->assertMatchesJsonSnapshot($result);
    }
}
