<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateShippingCollection extends Migration
{
    protected $collection = 'shipping';

    public function migrate(Blueprint $schema)
    {

    }
}
