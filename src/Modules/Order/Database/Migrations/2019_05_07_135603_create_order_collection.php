<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateOrderCollection extends Migration
{
    protected $collection = 'orders';

    public function migrate(Blueprint $schema)
    {

    }
}
