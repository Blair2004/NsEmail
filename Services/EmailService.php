<?php
namespace Modules\NsEmail\Services;

use Modules\NsEmail\Drivers\DefaultDriver;
use Modules\NsEmail\Drivers\MailgunDriver;
use Modules\NsEmail\Drivers\PostMarkDriver;
use Modules\NsEmail\Drivers\ResendDriver;
use Modules\NsEmail\Drivers\SMTPDriver;

class EmailService
{
    public function resolveDriver()
    {
        $name   =   ns()->option->get( 'ns_email_driver' );

        $driver     =   app( match( $name ) {
            'postmark' => PostMarkDriver::class,
            'smtp' => SMTPDriver::class,
            'resend' => ResendDriver::class,
            'mailgun' => MailgunDriver::class,
            default => DefaultDriver::class,
        } );

        return $driver->resolve();
    }

    public function overtakeDefaultConfigurations()
    {
        $ns_email_from_address =   ns()->option->get( 'ns_email_from_address' );
        $ns_email_from_name =   ns()->option->get( 'ns_email_from_name' );
        $ns_email_reply_to_address =   ns()->option->get( 'ns_email_reply_to_address' );
        $ns_email_reply_to_name =   ns()->option->get( 'ns_email_reply_to_name' );

        config([
            'mail.from.address' => $ns_email_from_address,
            'mail.from.name' => $ns_email_from_name,
            'mail.reply_to.address' => $ns_email_reply_to_address,
            'mail.reply_to.name' => $ns_email_reply_to_name,
        ]);
    }
}