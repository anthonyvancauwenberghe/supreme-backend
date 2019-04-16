<?php

namespace Modules\Mongo\Abstracts;

use Illuminate\Database\Migrations\Migration;

/**
 * Class MongoMigration.
 */
abstract class MongoMigration extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    abstract public function up();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    abstract public function down();
}
