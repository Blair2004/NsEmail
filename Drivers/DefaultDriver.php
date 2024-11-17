<?php
namespace Modules\NsEmail\Drivers;

class DefaultDriver
{
    public function resolve()
    {
        // no valid configuration was provided
        // we'll ignore to use the default value on the .env
    }
}