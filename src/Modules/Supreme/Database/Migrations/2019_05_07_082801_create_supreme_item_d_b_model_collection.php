<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateSupremeItemDBModelCollection extends Migration
{
    protected $collection = 'supreme_items';

    public function migrate(Blueprint $schema)
    {

    }
}
