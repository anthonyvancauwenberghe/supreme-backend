<?php

namespace Modules\Settings\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Settings\Policies\SettingsPolicy;
use Modules\Settings\Attributes\SettingsAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Settings.
 *
 * @property string $id
 */
class Settings extends Model implements SettingsAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner;

    protected $policies = [
        SettingsPolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'settings';

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
