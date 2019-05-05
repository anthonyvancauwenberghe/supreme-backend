<?php

namespace Modules\Lookbook\Abstracts;

use Foundation\Traits\ModelFactory;
use Jenssegers\Mongodb\Eloquent\Builder;
use Modules\Mongo\Abstracts\MongoModel;

abstract class Lookbook extends MongoModel
{
    use ModelFactory;

    /**
     * @var string
     */
    protected $collection = 'lookbook';

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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('season', function (Builder $builder) {
            $builder->where('season', self::getSeasonName());
        });

        static::creating(function ($query) {
            $query->season = self::getSeasonName();
        });
    }

    public static function getSeasonName(){
        return str_replace('lookbook','',strtolower(get_short_class_name(static::class)));
    }

}