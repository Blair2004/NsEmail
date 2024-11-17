<?php

namespace Modules\NsEmail\Listeners;

use App\Events\BeforeStartWebRouteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NsEmail\Services\EmailService;

class BeforeStartWebRouteEventListener
{
    /**
     * Handle the event.
     */
    public function handle( BeforeStartWebRouteEvent $event )
    {
        /**
         * @var EmailService $emailService
        */
        $emailService   =   app()->make( EmailService::class );
        $emailService->overtakeDefaultConfigurations();
        $emailService->resolveDriver();
    }
}
