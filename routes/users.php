<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['auth' , 'locale']], function() {

    Route::resource('users',UserController::class);

});



require __DIR__.'/auth.php';
