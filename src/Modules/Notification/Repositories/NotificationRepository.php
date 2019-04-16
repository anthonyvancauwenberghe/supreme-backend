<?php


namespace Modules\Notification\Repositories;

use Foundation\Abstracts\Repositories\Repository;
use Illuminate\Notifications\DatabaseNotification;

class NotificationRepository extends Repository
{
    protected $eloquent = DatabaseNotification::class;
}