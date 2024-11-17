<?php
namespace Modules\NsEmail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email'
        ];
    }
}