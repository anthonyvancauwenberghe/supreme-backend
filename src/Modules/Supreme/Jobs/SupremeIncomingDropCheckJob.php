<?php


namespace Modules\Supreme\Jobs;

use Cache;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Foundation\Abstracts\Jobs\Job;
use Modules\Supreme\Events\AmericaDropSoonEvent;
use Modules\Supreme\Events\EuropeDropSoonEvent;
use Modules\Supreme\Events\JapanDropSoonEvent;
use Modules\Supreme\Parsers\SupremeStockParser;
use Throwable;

class SupremeIncomingDropCheckJob extends Job
{
    protected $minutesBeforeDrop = 2;

    public function handle()
    {
        $this->checkRegion('japan', 'UTC +9:00', 6,11, new JapanDropSoonEvent());
        $this->checkRegion('europe', 'GMT', 4,11, new EuropeDropSoonEvent());
        $this->checkRegion('america', 'EST', 4,11, new AmericaDropSoonEvent());
    }

    public function checkRegion(string $region, string $timezone, int $dropDay,int $drophour, $event)
    {
        if ($this->getCache($region) === null) {
            $date = Carbon::now()->setTimezone($timezone);
            if ($date->isDayOfWeek($dropDay)) {
                if ($date->hour == $drophour - 1 && $date->minute >= 60 - $this->minutesBeforeDrop) {
                    event($event);
                    $this->putCache($region);
                }
            }
        }
    }

    protected function getCache($region)
    {
        return Cache::get("supreme:$region:drop:soon");
    }

    protected function putCache($region)
    {
        Cache::put("supreme:$region:drop:soon", true, $this->minutesBeforeDrop * 60);
    }

}