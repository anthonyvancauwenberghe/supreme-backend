<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 19:40.
 */

namespace Foundation\Abstracts\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

abstract class QueuedListener extends Listener implements ShouldQueue
{
    use InteractsWithQueue;
}
