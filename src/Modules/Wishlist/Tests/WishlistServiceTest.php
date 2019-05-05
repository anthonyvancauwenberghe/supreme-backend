<?php

namespace Modules\Wishlist\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Wishlist\Entities\Wishlist;

class WishlistServiceTest extends TestCase
{
    /**
     * @var Wishlist[]
     */
    protected $models;

    protected function seedData()
    {
        parent::seedData();
        $this->models = Wishlist::fromFactory(5)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWishlistCreation()
    {
        $this->assertNotEmpty($this->models->toArray());
    }
}
