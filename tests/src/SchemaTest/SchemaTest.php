<?php declare(strict_types=1);

namespace Tests\SchemaTest;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Schema\GraphQL;

/**
 * Class SchemaTest
 * @package Tests\Types\Scalars
 */
class SchemaTest extends TestCase
{
    use MatchesSnapshots;

    public function testRecord()
    {
        $query = <<< EOF
{
  record {
    id
    name
    date
    dateFormat
    dateTime
  }
}
EOF;
        $result = GraphQL::query($query);

        $this->assertMatchesJsonSnapshot($result);
    }
}
