<?php

namespace Modules\Order\Entities;

use Foundation\Traits\Notifiable;
use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Order\Policies\OrderPolicy;
use Modules\Order\Attributes\OrderAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Order.
 *
 * @property string $id
 */
class Order extends Model implements OrderAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner, Notifiable;

    protected $policies = [
        OrderPolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'orders';

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
        return $this->belongsTo(User::class);
    }
}
