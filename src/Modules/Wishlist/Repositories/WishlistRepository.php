<?php

namespace Modules\Wishlist\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Wishlist\Contracts\WishlistRepositoryContract;
use Modules\Wishlist\Entities\Wishlist;

class WishlistRepository extends Repository implements WishlistRepositoryContract
{
    protected $eloquent = Wishlist::class;
}
