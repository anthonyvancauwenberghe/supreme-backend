<?php

use Modules\Mongo\Abstracts\MongoCollectionMigration as Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateWishlistCollection extends Migration
{
    protected $collection = 'wishlists';

    public function migrate(Blueprint $schema)
    {

    }
}
