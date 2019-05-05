<?php

namespace Modules\Wishlist\Tests;

use Modules\Auth0\Abstracts\AuthorizedHttpTest;
use Modules\Authorization\Entities\Role;
use Modules\Wishlist\Contracts\WishlistServiceContract;
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
        $this->model = factory(Wishlist::class)->create(['user_id' => $this->getActingUser()->id]);
        $this->service = $this->app->make(WishlistServiceContract::class);
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
     * Test retrieving a Wishlist.
     *
     * @return void
     */
    public function testFindWishlist()
    {
        $response = $this->http('GET', '/v1/wishlists/'.$this->model->id);
        $response->assertStatus(200);

        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('GET', '/v1/wishlists/'.$this->model->id);
        $response->assertStatus(403);
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

        $this->assertArrayHasKeys(['notify','item_id','size_id','style_id'], $data);
    }

    /**
     * Test Updating a Wishlist.
     *
     * @return void
     */
    public function testUpdateWishlist()
    {
        /* Test response for a normal user */
        $response = $this->http('PATCH', '/v1/wishlists/'.$this->model->id, ["notify" => false]);
        $response->assertStatus(200);

        /* Test response for a guest user */
        $this->getActingUser()->syncRoles(Role::GUEST);
        $response = $this->http('PATCH', '/v1/wishlists/'.$this->model->id, []);
        $response->assertStatus(403);
    }
}
