<?php

namespace Foundation\Abstracts\Models;

/**
 * Class MongoModel.
 *
 * @mixin \Eloquent
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'mysql';

    protected $guard_name = "api";
}
