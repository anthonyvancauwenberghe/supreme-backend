<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateCreditcardCollection extends Migration
{
    protected $collection = 'credit_cards';

    public function migrate(Blueprint $schema)
    {

    }
}