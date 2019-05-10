<?php

namespace Modules\Settings\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Settings\Attributes\SettingsAttributes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Settings.
 *
 * @property string $id
 * @property User|null $user
 */
class Settings extends Model implements SettingsAttributes, Ownable
{
    use HasOwner;

    public $timestamps = false;

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
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ownedBy()
    {
        return User::class;
    }
}
