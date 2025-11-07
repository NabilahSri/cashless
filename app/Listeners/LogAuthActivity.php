<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;

class LogAuthActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        if ($user) {
            $agent = new Agent();
            $agent->setUserAgent(Request::header('User-Agent'));

            activity()
                ->causedBy($user)
                ->event($event instanceof Login ? 'login' : 'logout')
                ->tap(function ($activity) use ($agent) {
                    $activity->ip_address = Request::ip();
                    $activity->device = $agent->device();
                    $activity->platform = $agent->platform();
                    $activity->browser = $agent->browser();
                })
                ->log($event instanceof Login ? 'User has successfully logged in.' : 'User has successfully logged out.');
        }
    }
}
