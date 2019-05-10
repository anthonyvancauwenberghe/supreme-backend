<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateDeviceCollection extends Migration
{
    protected $collection = 'devices';

    public function migrate(Blueprint $schema)
    {

    }
}
