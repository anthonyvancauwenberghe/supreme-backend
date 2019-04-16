<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 15:51
 */

namespace Foundation\Contracts;


interface EventContract
{
    /**
     * Dispatch the event with the given arguments.
     *
     * @return void
     */
    public static function dispatch();

    /**
     * Broadcast the event with the given arguments.
     *
     * @return \Illuminate\Broadcasting\PendingBroadcast
     */
    public static function broadcast();
}
