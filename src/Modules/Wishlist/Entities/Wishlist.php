<?php

namespace Modules\Wishlist\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Wishlist\Policies\WishlistPolicy;
use Modules\Wishlist\Attributes\WishlistAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Wishlist.
 *
 * @property string $id
 */
class Wishlist extends Model implements WishlistAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner;

    protected $policies = [
        WishlistPolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'wishlists';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function ownedBy()
    {
        return User::class;
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

}
