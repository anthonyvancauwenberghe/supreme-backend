<?php

namespace Modules\Supreme\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Supreme\Policies\SupremeItemDBModelPolicy;
use Modules\Supreme\Attributes\SupremeItemDBModelAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class SupremeItemDBModel.
 *
 * @property string $id
 */
class SupremeItemDBModel extends Model
{
    /**
     * @var string
     */
    protected $collection = 'supreme_items';

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
        'updated_at'
    ];

}
