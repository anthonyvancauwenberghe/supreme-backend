<?php

namespace Modules\Telescope\Providers;

use Foundation\Contracts\ConditionalAutoRegistration;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider implements ConditionalAutoRegistration
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);

        //Telescope::night();

        Telescope::filter(function (IncomingEntry $entry) {
            if (is_bool($filter = $this->filterHorizonEntries($entry))) {
                return $filter;
            }

            if (is_bool($filter = $this->filterCorsRequests($entry))) {
                return $filter;
            }

            if ($this->app->environment('local')) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    protected function filterHorizonEntries(IncomingEntry $entry)
    {
        if ($entry->type === EntryType::REQUEST
            && isset($entry->content['uri'])
            && str_contains($entry->content['uri'], 'horizon')) {
            return false;
        }

        if ($entry->type === EntryType::EVENT
            && isset($entry->content['name'])
            && str_contains($entry->content['name'], 'Horizon')) {
            return false;
        }
    }

    protected function filterCorsRequests(IncomingEntry $entry)
    {
        if ($entry->type === EntryType::REQUEST
            && isset($entry->content['method'])
            && $entry->content['method'] === 'OPTIONS') {
            return false;
        }
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    public function registrationCondition(): bool
    {
        return app()->environment('local');
    }
}
