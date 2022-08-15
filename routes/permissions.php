<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionsController;

Route::group(['middleware' => ['auth' , 'locale']], function() {

Route::resource('permissions',PermissionsController::class);

});



require __DIR__.'/auth.php';
