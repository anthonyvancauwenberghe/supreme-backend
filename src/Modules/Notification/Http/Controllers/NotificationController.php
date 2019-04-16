<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 14.10.18
 * Time: 18:58.
 */

namespace Modules\Notification\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Notification\Contracts\NotificationServiceContract;
use Modules\Notification\Services\NotificationService;
use Modules\Notification\Transformers\NotificationTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationController extends Controller
{
    /**
     * @var NotificationService
     */
    protected $service;

    /**
     * NotificationController constructor.
     *
     * @param $service
     */
    public function __construct(NotificationServiceContract $service)
    {
        $this->service = $service;
    }

    public function all()
    {
        return NotificationTransformer::collection($this->service->allNotificationsByUser(get_authenticated_user()));
    }

    public function allUnread()
    {
        return NotificationTransformer::collection($this->service->unreadNotifcationsByUser(get_authenticated_user()));
    }

    public function read($id)
    {
        if (! $this->service->find($id)->notifiable()->is(auth()->user())) {
            throw new NotFoundHttpException('notification not found');
        }

        $this->service->markAsRead($id);

        return response()->json([
            'success',
        ]);
    }

    public function unread($id)
    {
        if (! $this->service->find($id)->notifiable()->is(auth()->user())) {
            throw new NotFoundHttpException('notification not found');
        }

        $this->service->markAsUnread($id);

        return response()->json([
            'success',
        ]);
    }
}
