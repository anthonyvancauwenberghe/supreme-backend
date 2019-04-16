<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:10.
 */

namespace Modules\User\Notifications;

use Modules\Notification\Abstracts\WebNotification;

class WelcomeUserWebNotification extends WebNotification
{
    protected function title(): string
    {
        return 'Welcome to astralbot!';
    }

    protected function message(): string
    {
        return 'We hope you will enjoy our platform!';
    }
}
