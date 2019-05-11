<?php

namespace Modules\Wishlist\Contracts;

use Modules\Wishlist\Entities\Wishlist;
use Modules\Wishlist\Dtos\CreateWishlistData;
use Modules\Wishlist\Dtos\UpdateWishlistData;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

interface WishlistServiceContract
{
    /**
     * @param $id
     * @return Wishlist
     */
    public function find($id): Wishlist;

    /**
     * @param $user
     * @return Wishlist[]
     */
    public function fromUser($user): Collection;

    /**
     * @param $id
     * @param CreateWishlistData $data
     * @return Wishlist
     */
    public function create(CreateWishlistData $data, User $user): Wishlist;


    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool;
}
