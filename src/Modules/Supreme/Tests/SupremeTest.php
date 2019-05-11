<?php


namespace Modules\Supreme\Tests;


use Foundation\Abstracts\Tests\TestCase;
use Modules\Supreme\Cache\SupremeDropListCache;
use Modules\Supreme\Entities\SupremeItemDBModel;
use Supreme\Parser\SupremeCommunityLatestDroplistParser;

class SupremeTest extends TestCase
{
    public function testSupremeDroplistCaching()
    {
        $this->markTestSkipped();

        $parser = new SupremeCommunityLatestDroplistParser(2,true);
        $items = $parser->parse();
        $this->assertNotEmpty($items);
    }
}
