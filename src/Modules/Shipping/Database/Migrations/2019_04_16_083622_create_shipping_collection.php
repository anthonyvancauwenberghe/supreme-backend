<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateShippingCollection extends Migration
{
    protected $collection = 'shippings';

    public function migrate(Blueprint $schema)
    {

    }
}
