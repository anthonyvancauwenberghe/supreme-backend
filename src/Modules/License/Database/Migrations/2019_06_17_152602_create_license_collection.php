<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateLicenseCollection extends Migration
{
    protected $collection = 'licenses';

    public function migrate(Blueprint $schema)
    {

    }
}
