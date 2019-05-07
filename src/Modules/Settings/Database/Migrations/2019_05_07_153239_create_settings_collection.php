<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateSettingsCollection extends Migration
{
    protected $collection = 'settings';

    public function migrate(Blueprint $schema)
    {

    }
}
