<?php

namespace Modules\Mongo\Abstracts;

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

/**
 * Class MongoCollectionMigration.
 *
 * @method void migrate(Blueprint $collection)
 * @method void destroy()
 */
abstract class MongoCollectionMigration extends MongoMigration
{
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

    /**
     * Run the migrations.
     *
     * @return void
     */
    final public function up()
    {
        if (! Schema::connection($this->connection)->hasTable($this->collection)) {
            Schema::connection($this->connection)->create($this->collection, function (Blueprint $collection) {
                if (method_exists($this, 'migrate')) {
                    $this->migrate($collection);
                }
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
        if (Schema::connection($this->connection)->hasCollection($this->collection)) {
            if (method_exists($this, 'destroy')) {
                $this->destroy();
            }
            Schema::connection($this->connection)->drop($this->collection);
        }
    }
}
