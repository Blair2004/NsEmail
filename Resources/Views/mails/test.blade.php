<x-mail::message>
# {{ __m( 'Test Mail', 'NsEmail' )}}
 
{{ __m( 'If you can see this mail, then the mail services works correctly with the Email module for NexoPOS.', 'NsEmail' )}}

<br>

{{ 
    sprintf( 
        __m( 'This test mail was sent using "%s" driver.', 'NsEmail' ),
        ( new Modules\NsEmail\Settings\EmailSettings )->driverOptions[ ns()->option->get( 'ns_email_driver' ) ] ?? __m( 'Unknown', 'NsEmail' )
    )
}}
 
{{ __m( 'Thanks', 'NsEmail' )}},
{{ config('app.name') }}

</x-mail::message>