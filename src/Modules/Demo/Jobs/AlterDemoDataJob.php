<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 28.10.18
 * Time: 17:25.
 */

namespace Modules\Demo\Jobs;

use Foundation\Abstracts\Jobs\Job;
use Modules\Auth0\Contracts\Auth0ServiceContract;
use Modules\Auth0\Services\Auth0Service;
use Modules\Auth0\Traits\Auth0TestUser;

class AlterDemoDataJob extends Job
{

    public function __construct()
    {

    }

    public function handle()
    {

    }
}
