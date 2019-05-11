<?php

namespace Modules\Wishlist\Services;

use Modules\Wishlist\Entities\Wishlist;
use Modules\Wishlist\Events\WishlistWasCreatedEvent;
use Modules\Wishlist\Events\WishlistWasUpdatedEvent;
use Modules\Wishlist\Events\WishlistWasDeletedEvent;
use Modules\Wishlist\Contracts\WishlistServiceContract;
use Modules\Wishlist\Dtos\CreateWishlistData;
use Modules\Wishlist\Dtos\UpdateWishlistData;
use Modules\Wishlist\Contracts\WishlistRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Modules\User\Entities\User;

class WishlistService implements WishlistServiceContract
{

    /**
     * @var WishlistRepositoryContract
     */
    protected $repository;

    /**
     * WishlistService constructor.
     * @param $repository
     */
    public function __construct(WishlistRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return Wishlist
     */
    public function find($id): Wishlist
    {
        return $this->repository->findOrResolve($id);
    }

    /**
     * @param $user
     * @return Wishlist[]
     */
    public function fromUser($user): Collection
    {
        if ($user instanceof User)
            $user = $user->id;
        return $this->repository->findByField('user_id', $user);
    }

    /**
     * @param CreateWishlistData $data
     * @return Wishlist
     */
    public function create(CreateWishlistData $data, User $user): Wishlist
    {
        $data->with('user_id', $user->id);
        $wishlist = $this->repository->create($data->toArray());
        event(new WishlistWasCreatedEvent($wishlist));
        return $wishlist;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $wishlist = $this->repository->findOrResolve($id);
        $deleted = $this->repository->delete($wishlist);
        if($deleted)
            event(new WishlistWasDeletedEvent($wishlist));
        return $deleted;
    }
}
