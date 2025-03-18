<?php
/**
 * Email Manager Settings
 * @since 1.0
**/
namespace Modules\NsEmail\Settings;

use App\Classes\FormInput;
use App\Classes\Hook;
use App\Classes\Output;
use App\Classes\SettingForm;
use App\Events\RenderFooterEvent;
use App\Services\SettingsPage;
use App\Services\ModulesService;
use App\Services\Helper;
use Illuminate\Support\Facades\Event;

class EmailSettings extends SettingsPage
{
    const AUTOLOAD = true;
    const IDENTIFIER      =   'ns-email-settings';

    public array $driverOptions;

    public function __construct()
    {
        $this->driverOptions    =   [
            'smtp' => __m( 'SMTP', 'NsEmail' ),
            'sendmail' => __m( 'Sendmail', 'NsEmail' ),
            'mailgun' => __m( 'Mailgun', 'NsEmail' ),
            'postmark' => __m( 'Postmark', 'NsEmail' ),
            'resend'    =>  __m( 'Resend', 'NsEmail' ),
            'log' => __m( 'Log', 'NsEmail' ),
        ];

        /**
         * Settings Form definition.
         */
        $this->form   = SettingForm::form(
            title: __m( 'Email Settings', 'NsEmail' ),
            description: __m( 'Configure your email settings.', 'NsEmail' ),
            tabs: SettingForm::tabs(
                SettingForm::tab(
                    identifier: 'general',
                    label: __m( 'General', 'NsEmail' ),
                    fields: SettingForm::fields(
                        FormInput::select(
                            label: __m( 'Email Driver', 'NsEmail' ),
                            name: 'ns_email_driver',
                            options: Helper::kvToJsOptions( $this->driverOptions ),
                            value: ns()->option->get( 'ns_email_driver' ),
                            description: __m( 'The email driver to use for sending emails.', 'NsEmail' ),
                        ),
                        ...$this->getSMTPFields(),
                        ...$this->getSendmailFields(),
                        ...$this->getMailgunFields(),
                        ...$this->getPostmarkFields(),
                        ...$this->getSESFields(),
                        ...$this->getResendFields(),
                    ),
                    footer: SettingForm::tabFooter(
                        extraComponents: [ 'nsEmailTestSettings' ]
                    )
                ),
                SettingForm::tab(
                    identifier: 'sender',
                    label: __m( 'Sender', 'NsEmail' ),
                    fields: SettingForm::fields(
                        FormInput::text(
                            label: __m( 'From Address', 'NsEmail' ),
                            name: 'ns_email_from_address',
                            value: ns()->option->get( 'ns_email_from_address' ),
                            description: __m( 'The email address to send from.', 'NsEmail' ),
                        ),
                        FormInput::text(
                            label: __m( 'From Name', 'NsEmail' ),
                            name: 'ns_email_from_name',
                            value: ns()->option->get( 'ns_email_from_name' ),
                            description: __m( 'The name to send from.', 'NsEmail' ),
                        ),
                        FormInput::text(
                            label: __m( 'Reply To Address', 'NsEmail' ),
                            name: 'ns_email_reply_to_address',
                            value: ns()->option->get( 'ns_email_reply_to_address' ),
                            description: __m( 'The email address to reply to.', 'NsEmail' ),
                        ),
                        FormInput::text(
                            label: __m( 'Reply To Name', 'NsEmail' ),
                            name: 'ns_email_reply_to_name',
                            value: ns()->option->get( 'ns_email_reply_to_name' ),
                            description: __m( 'The name to reply to.', 'NsEmail' ),
                        ),
                    )
                )
            )
        );
    }

    public function getResendFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'resend' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'API Key', 'NsEmail' ),
                name: 'ns_email_resend_api_key',
                description: __m( 'The Resend API key.', 'NsEmail' ),
                value: ns()->option->get( 'ns_email_resend_api_key' ),
            )
        );
    }

    public function getSMTPFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'smtp' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'Host', 'NsEmail' ),
                name: 'ns_email_smtp_host',
                value: ns()->option->get( 'ns_email_smtp_host' ),
                description: __m( 'The SMTP host to connect to.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Port', 'NsEmail' ),
                name: 'ns_email_smtp_port',
                value: ns()->option->get( 'ns_email_smtp_port' ),
                description: __m( 'The SMTP port to connect to.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Username', 'NsEmail' ),
                name: 'ns_email_smtp_username',
                value: ns()->option->get( 'ns_email_smtp_username' ),
                description: __m( 'The SMTP username.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Password', 'NsEmail' ),
                name: 'ns_email_smtp_password',
                value: ns()->option->get( 'ns_email_smtp_password' ),
                description: __m( 'The SMTP password.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Encryption', 'NsEmail' ),
                name: 'ns_email_smtp_encryption',
                value: ns()->option->get( 'ns_email_smtp_encryption' ),
                description: __m( 'The SMTP encryption.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'From Address', 'NsEmail' ),
                name: 'ns_email_smtp_from_address',
                value: ns()->option->get( 'ns_email_smtp_from_address' ),
                description: __m( 'The email address to send from.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'From Name', 'NsEmail' ),
                name: 'ns_email_smtp_from_name',
                value: ns()->option->get( 'ns_email_smtp_from_name' ),
                description: __m( 'The name to send from.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Reply To Address', 'NsEmail' ),
                name: 'ns_email_smtp_reply_to_address',
                value: ns()->option->get( 'ns_email_smtp_reply_to_address' ),
                description: __m( 'The email address to reply to.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Reply To Name', 'NsEmail' ),
                name: 'ns_email_smtp_reply_to_name',
                value: ns()->option->get( 'ns_email_smtp_reply_to_name' ),
                description: __m( 'The name to reply to.', 'NsEmail' ),
            ),
        );
    }

    public function getSendmailFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'sendmail' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'Path', 'NsEmail' ),
                name: 'ns_email_sendmail_path',
                value: ns()->option->get( 'ns_email_sendmail_path' ),
                description: __m( 'The path to the sendmail binary.', 'NsEmail' ),
            ),
        );
    }

    public function getMailgunFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'mailgun' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'Domain', 'NsEmail' ),
                name: 'ns_email_mailgun_domain',
                value: ns()->option->get( 'ns_email_mailgun_domain' ),
                description: __m( 'The Mailgun domain.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Secret', 'NsEmail' ),
                name: 'ns_email_mailgun_secret',
                value: ns()->option->get( 'ns_email_mailgun_secret' ),
                description: __m( 'The Mailgun secret.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Endpoint', 'NsEmail' ),
                name: 'ns_email_mailgun_endpoint',
                value: ns()->option->get( 'ns_email_mailgun_endpoint' ),
                description: __m( 'The Mailgun Endpoint.', 'NsEmail' ),
            ),
        );
    }

    public function getPostmarkFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'postmark' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'Token', 'NsEmail' ),
                name: 'ns_email_postmark_token',
                value: ns()->option->get( 'ns_email_postmark_token' ),
                description: __m( 'The Postmark token.', 'NsEmail' ),
            ),
        );
    }

    public function getSESFields()
    {
        if ( ns()->option->get( 'ns_email_driver' ) !== 'ses' ) {
            return [];
        }

        return SettingForm::fields(
            FormInput::text(
                label: __m( 'Key', 'NsEmail' ),
                name: 'ns_email_ses_key',
                value: ns()->option->get( 'ns_email_ses_key' ),
                description: __m( 'The SES key.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Secret', 'NsEmail' ),
                name: 'ns_email_ses_secret',
                value: ns()->option->get( 'ns_email_ses_secret' ),
                description: __m( 'The SES secret.', 'NsEmail' ),
            ),
            FormInput::text(
                label: __m( 'Region', 'NsEmail' ),
                name: 'ns_email_ses_region',
                value: ns()->option->get( 'ns_email_ses_region' ),
                description: __m( 'The SES region.', 'NsEmail' ),
            ),
        );
    }

    public function beforeRenderForm()
    {
        Event::listen( RenderFooterEvent::class, function( RenderFooterEvent $event ) {
            $event->output->addView( 'NsEmail::settings.email-test' );
        });
    }
}