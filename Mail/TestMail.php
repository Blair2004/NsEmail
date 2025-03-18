<?php
namespace Modules\NsEmail\Mail;

use App\Services\NotificationService;
use App\Traits\NsJobPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Modules\NsEmail\Settings\EmailSettings;
use Throwable;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
    * Get the message envelope.
    *
    * @return \Illuminate\Mail\Mailables\Envelope
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __m( 'Test Mail', 'NsEmail' ),
            tags: [],
            metadata: [
                // ...
            ],
        );
    }
 
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'NsEmail::mails.test'
        );
    }

    public function failed( Throwable $exception)
    {
        app()->make( NotificationService::class )->create(
            title: __m( 'Test Mail Failed', 'NsEmail' ),
            description: sprintf(
                __m( 'Test mail failed with error: %s', 'NsEmail' ),
                $exception->getMessage()
            ),
            url: ns()->route( 'ns.dashboard.settings', [ 'settings' => EmailSettings::IDENTIFIER ])
        )->dispatchForPermissions( [ 'manage.options' ] );
    }
}