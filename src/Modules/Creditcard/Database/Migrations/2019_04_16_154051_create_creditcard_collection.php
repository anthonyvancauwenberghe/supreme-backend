<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateCreditcardCollection extends Migration
{
    protected $collection = 'creditcards';

    public function migrate(Blueprint $schema)
    {

    }
}
