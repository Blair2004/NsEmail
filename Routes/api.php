<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use Modules\NsEmail\Http\Controllers\MainController;

Route::prefix( 'nsemail' )->group( function() {
    Route::middleware([
        SubstituteBindings::class,
    ])->group( function() {
        Route::post( 'test', [ MainController::class, 'testMail' ]);
    });
});