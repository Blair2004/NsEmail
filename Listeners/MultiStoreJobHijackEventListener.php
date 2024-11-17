<?php

namespace Modules\NsEmail\Listeners;

use Modules\NsEmail\Services\EmailService;
use Modules\NsMultiStore\Events\MultiStoreJobHijackEvent;

class MultiStoreJobHijackEventListener
{
    /**
     * Handle the event.
     */
    public function handle( MultiStoreJobHijackEvent $event )
    {
        /**
         * @var EmailService $emailService
        */
        $emailService   =   app()->make( EmailService::class );
        $emailService->overtakeDefaultConfigurations();
        $emailService->resolveDriver();
    }
}
