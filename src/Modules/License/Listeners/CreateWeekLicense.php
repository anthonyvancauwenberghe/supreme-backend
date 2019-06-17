<?php


namespace Modules\License\Listeners;


use Carbon\Carbon;
use Foundation\Abstracts\Listeners\QueuedListener;
use Modules\License\Contracts\LicenseServiceContract;
use Modules\License\Dtos\CreateLicenseData;
use Modules\User\Events\UserRegisteredEvent;

class CreateWeekLicense extends QueuedListener
{
    protected $service;

    /**
     * CreateWeekLicense constructor.
     * @param $service
     */
    public function __construct(LicenseServiceContract $service)
    {
        $this->service = $service;
    }


    public function handle(UserRegisteredEvent $event)
    {
        $this->service->create(new CreateLicenseData([
            "type" => "WEEK",
            "expires_at" => Carbon::now()->addWeek()->toDateTimeString(),
        ]), $event->user);
    }
}
