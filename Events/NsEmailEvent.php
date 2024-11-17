<?php
namespace Modules\NsEmail\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Register Event
**/
class NsEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct()
    {
        // ...
    }
}