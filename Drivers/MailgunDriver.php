<?php
namespace Modules\NsEmail\Drivers;

class MailgunDriver
{
    public function resolve()
    {
        config([
            'mail.default'   =>  'mailgun',
            'services.mailgun.domain'   =>  ns()->option->get( 'ns_email_mailgun_domain' ),
            'services.mailgun.secret'   =>  ns()->option->get( 'ns_email_mailgun_secret' ),
            'services.mailgun.endpoint'   =>  ns()->option->get( 'ns_email_mailgun_endpoint' ),
        ]);
    }
}