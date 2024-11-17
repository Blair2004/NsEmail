<?php
namespace Modules\NsEmail;

use Illuminate\Support\Facades\Event;
use App\Services\Module;

class NsEmailModule extends Module
{
    public function __construct()
    {
        parent::__construct( __FILE__ );
    }
}