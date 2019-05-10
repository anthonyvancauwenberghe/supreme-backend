<?php

namespace Modules\Device\Entities;

use Illuminate\Notifications\Notifiable;
use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Device\Attributes\DeviceAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Device.
 *
 * @property string $id
 */
class Device extends Model implements DeviceAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner, Notifiable;

    /**
     * @var string
     */
    protected $collection = 'devices';

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
}
