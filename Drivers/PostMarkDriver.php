<?php
namespace Modules\NsEmail\Drivers;

class PostMarkDriver
{
    public function resolve()
    {
        config([
            'mail.default'   =>  'postmark',
            'services.postmark.token'   =>  env('POSTMARK_TOKEN'),
        ]);
    }
}