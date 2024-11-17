<?php
namespace Modules\NsEmail\Drivers;

class SMTPDriver 
{
    public function resolve()
    {
        config([
            'mail.default' => 'smtp',
            'mail.host' => ns()->option->get( 'ns_email_smtp_host' ),
            'mail.port' => ns()->option->get( 'ns_email_smtp_port' ),
            'mail.encryption' => ns()->option->get( 'ns_email_smtp_encryption' ),
            'mail.username' => ns()->option->get( 'ns_email_smtp_username' ),
            'mail.password' => ns()->option->get( 'ns_email_smtp_password' ),
            'mail.from.address' => ns()->option->get( 'ns_email_smtp_from_address' ),
            'mail.from.name' => ns()->option->get( 'ns_email_smtp_from_name' ),
        ]);
    }
}