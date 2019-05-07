<?php

namespace Modules\Settings\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Modules\Settings\Contracts\SettingsRepositoryContract;
use Modules\Settings\Entities\Settings;

class SettingsRepository extends Repository implements SettingsRepositoryContract
{
    protected $eloquent = Settings::class;
}
