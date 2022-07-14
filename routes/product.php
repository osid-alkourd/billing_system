<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;




Route::group([
    'prefix' => '/product',
    'as' => 'product.',
    'middleware' => ['auth'],
] , function(){

    Route::get('/' , [ProductController::class  , 'index'])->name('list');
    Route::post('/store' , [ProductController::class , 'store'])->name('store');
    Route::put('/update' , [ProductController::class , 'update'])->name('update');
    Route::delete('/delete' , [ProductController::class , 'destroy'])->name('delete');
});

require __DIR__.'/auth.php';
