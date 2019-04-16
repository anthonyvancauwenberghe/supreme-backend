<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 28.10.18
 * Time: 16:16.
 */

namespace Modules\Demo\Jobs;

use Foundation\Abstracts\Jobs\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Modules\Demo\Database\Seeders\DemoSeeder;

class SeedDemoDataJob extends Job implements ShouldQueue
{
    public function handle()
    {
        Model::unguarded(function () {
            $seeder = app()->make(DemoSeeder::class);
            $seeder->__invoke();
        });
    }
}
