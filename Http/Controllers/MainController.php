<?php

/**
 * Email Manager Controller
 * @since 1.0
 * @package modules/NsEmail
**/

namespace Modules\NsEmail\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\NsEmail\Http\Requests\TestMailRequest;
use Modules\NsEmail\Mail\TestMail;

class MainController extends Controller
{
    public function testMail( TestMailRequest $request )
    {
        Mail::to( $request->input('email') )
            ->queue( new TestMail() );

        return [
            'status' => 'success',
            'message' => __m( 'The mail was queued. Make sure to check the spams folder if you can\'t find it in your inbox.', 'NsEmail' )
        ];
    }
}
