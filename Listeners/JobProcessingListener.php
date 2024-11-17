<?php

namespace Modules\NsEmail\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\InteractsWithQueue;
use Modules\NsEmail\Services\EmailService;

class JobProcessingListener
{
    /**
     * Handle the event.
     */
    public function handle( JobProcessing $event )
    {
        /**
         * @var EmailService $emailService
        */
        $emailService   =   app()->make( EmailService::class );
        $emailService->overtakeDefaultConfigurations();
        $emailService->resolveDriver();
    }
}
