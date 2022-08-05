<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::group(['middleware' => ['auth' , 'locale']], function() {

Route::resource('roles',RoleController::class);

});



require __DIR__.'/auth.php';
