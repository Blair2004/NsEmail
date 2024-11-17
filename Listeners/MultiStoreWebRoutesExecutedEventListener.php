<?php

namespace Modules\NsEmail\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NsEmail\Services\EmailService;
use Modules\NsMultiStore\Events\MultiStoreWebRoutesExecutedEvent;

class MultiStoreWebRoutesExecutedEventListener
{
    /**
     * Handle the event.
     */
    public function handle( MultiStoreWebRoutesExecutedEvent $event )
    {
        /**
         * @var EmailService $emailService
        */
        $emailService   =   app()->make( EmailService::class );
        $emailService->overtakeDefaultConfigurations();
        $emailService->resolveDriver();
    }
}
