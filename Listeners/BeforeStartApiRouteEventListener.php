<?php

namespace Modules\NsEmail\Listeners;

use App\Events\BeforeStartApiRouteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NsEmail\Services\EmailService;

class BeforeStartApiRouteEventListener
{
    /**
     * Handle the event.
     */
    public function handle( BeforeStartApiRouteEvent $event )
    {
        /**
         * @var EmailService $emailService
        */
        $emailService   =   app()->make( EmailService::class );
        $emailService->overtakeDefaultConfigurations();
        $emailService->resolveDriver();
    }
}
