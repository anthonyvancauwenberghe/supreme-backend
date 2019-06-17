<?php

namespace Modules\License\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\License\Policies\LicensePolicy;
use Modules\License\Attributes\LicenseAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class License.
 *
 * @property string $id
 */
class License extends Model implements LicenseAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner;

    protected $policies = [
        LicensePolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'licenses';

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
