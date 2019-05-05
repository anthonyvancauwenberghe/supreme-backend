<?php

namespace Modules\Creditcard\Entities;

use Modules\Mongo\Abstracts\MongoModel as Model;
use Modules\Creditcard\Policies\CreditcardPolicy;
use Modules\Creditcard\Attributes\CreditcardAttributes;
use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Foundation\Contracts\Ownable;
use Foundation\Traits\HasOwner;
use Modules\User\Entities\User;

/**
 * Class Creditcard.
 *
 * @property string $id
 */
class Creditcard extends Model implements CreditcardAttributes, Ownable
{
    use ModelFactory, SoftDeletes, HasOwner;

    protected $policies = [
        CreditcardPolicy::class
    ];

    protected $observers = [

    ];

    /**
     * @var string
     */
    protected $collection = 'credit_cards';

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

    public function getNumberAttribute($value){
        return decrypt($value);
    }


}
