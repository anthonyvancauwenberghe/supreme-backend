<?php

namespace Modules\Wishlist\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Wishlist\Contracts\WishlistServiceContract;
use Modules\Wishlist\Dtos\CreateWishlistData;
use Modules\Wishlist\Entities\Wishlist;
use Modules\Wishlist\Services\WishlistService;
use Modules\Wishlist\Transformers\WishlistTransformer;

class WishlistHttpTest extends AuthorizedHttpTest
{
    protected $roles = Role::MEMBER;

    /**
     * @var Wishlist
     */
    protected $model;

    /**
     * @var WishlistService
     */
    protected $service;

    protected function seedData()
    {
        parent::seedData();
        $this->service = $this->app->make(WishlistServiceContract::class);
        $this->model = $this->service->create(CreateWishlistData::fromFactory(Wishlist::class), $this->getActingUser());

    }

    /**
     * Test retrieving all wishlists.
     *
     * @return void
     */
    public function testIndexWishlists()
    {
        $response = $this->http('GET', '/v1/wishlists');
        $response->assertStatus(200);
    }


    /**
     * Test Wishlist Deletion.
     *
     * @return void
     */
    public function testDeleteWishlist()
    {
        $response = $this->http('DELETE', '/v1/wishlists/'.$this->model->id);
        $response->assertStatus(204);

        $this->assertNull(Wishlist::find($this->model->id));
    }

    /**
     * Test Wishlist Creation.
     *
     * @return void
     */
    public function testCreateWishlist()
    {
        $model = Wishlist::fromFactory()->make([]);
        $response = $this->http('POST', '/v1/wishlists', $model->toArray());
        $response->assertStatus(201);
        $data = $response->decode();

        $this->assertArrayHasKeys(['notify', 'item_id', 'size_id', 'style_id'], $data);
    }
}
