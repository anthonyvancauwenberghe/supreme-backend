<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 11.10.18
 * Time: 22:53.
 */

namespace Foundation\Traits;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

trait RefreshDatabase
{
    use DatabaseMigrations {
        DatabaseMigrations::runDatabaseMigrations as parentMethod;
    }

    public function runDatabaseMigrations()
    {
        $this->artisan('cache:model:clear');

        /* If refresh fails. It usually means the database was only partially migrated or seeded.
        ** Start fresh if that's the case
        **/
        try {
            $this->artisan('migrate:refresh');
        } catch (\Exception $e) {
            $this->artisan('cache:model:clear');
            $this->artisan('migrate:fresh');
            $this->artisan('migrate:refresh');
        }
        $this->artisan('db:seed');
        $this->beforeApplicationDestroyed(function () {
            RefreshDatabaseState::$migrated = false;
        });
    }
}
