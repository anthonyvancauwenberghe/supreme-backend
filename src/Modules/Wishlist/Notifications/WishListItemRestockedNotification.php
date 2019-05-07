<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:10.
 */

namespace Modules\Wishlist\Notifications;

use Illuminate\Notifications\Notification;
use Modules\Supreme\Models\SupremeItem;

class WishListItemRestockedNotification extends Notification
{
    public $item;

    /**
     * WishListItemRestockedNotification constructor.
     * @param $item
     */
    public function __construct(SupremeItem $item)
    {
        $this->item = $item;
    }


}
