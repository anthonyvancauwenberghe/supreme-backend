<?php

namespace Modules\License\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\License\Contracts\LicenseRepositoryContract;
use Modules\License\Entities\License;

class LicenseRepository extends Repository implements LicenseRepositoryContract
{
    protected $eloquent = License::class;
}
