<?php
namespace Modules\NsEmail\Drivers;

class ResendDriver 
{
    public function resolve()
    {
        config([
            'mail.default'  =>  'resend',
            'services.resend.key'   =>  ns()->option->get( 'ns_email_resend_api_key' ),
        ]);
    }
}