<?php declare(strict_types=1);

namespace Tests\SchemaTest;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Schema\GraphQL;

/**
 * Class MoneyTypeTest
 * @package Tests\SchemaTest
 */
class MoneyTypeTest extends TestCase
{
    use MatchesSnapshots;

    public function testDate()
    {
        $query = '{ record { money } }';
        $result = GraphQL::query($query);
        $this->assertMatchesJsonSnapshot($result);
    }
}
