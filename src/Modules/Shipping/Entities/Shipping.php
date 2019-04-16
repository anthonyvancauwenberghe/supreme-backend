<?php

namespace Modules\Shipping\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Shipping\Policies\ShippingPolicy;
use Modules\Shipping\Attributes\ShippingAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;

/**
 * Class Shipping.
 *
 * @property string $id
 */
class Shipping extends Model implements ShippingAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner;

    protected $policies = [
        ShippingPolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'shippings';

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
}
