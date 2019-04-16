<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 03.10.18
 * Time: 20:57.
 */

namespace Foundation\Abstracts\Migrations;

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

abstract class MongoMigration extends \Illuminate\Database\Migrations\Migration
{
    protected $connection = 'mongodb';

    protected $collection;

    /**
     * MongoMigration constructor.
     */
    public function __construct()
    {
        if (! isset($this->collection) || $this->collection === '') {
            throw new InternalErrorException('Collection name must be specified on migration: '.get_called_class());
        }
    }

    abstract protected function migrate(Blueprint $collection);

    /**
     * Run the migrations.
     *
     * @return void
     */
    final public function up()
    {
        if (! Schema::connection($this->connection)->hasTable($this->collection)) {
            Schema::connection($this->connection)->create($this->collection, function (Blueprint $collection) {
                $this->migrate($collection);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    final public function down()
    {
        if (Schema::connection($this->connection)->hasTable($this->collection)) {
            Schema::connection($this->connection)->drop($this->collection);
        }
    }
}
