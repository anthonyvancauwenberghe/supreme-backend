<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateLookbookCollection extends Migration
{
    protected $collection = 'lookbook';

    public function migrate(Blueprint $schema)
    {
        $schema->index('url');
    }
}
