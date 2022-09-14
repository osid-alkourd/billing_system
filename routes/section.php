<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceController;


/*
Route::get('/create/section' , [SectionController::class  , 'create'] )
->middleware(['auth'])->name('section.create');
*/


Route::group([
    'prefix' => '/section',
    'as' => 'section.',
    'middleware' => ['auth' , 'locale'],
] , function(){

    Route::get('/' , [SectionController::class  , 'index'])->name('list');
    Route::post('/store' , [SectionController::class , 'store'])->name('store');
    Route::put('/update' , [SectionController::class , 'update'])->name('update');
    Route::delete('/delete' , [SectionController::class , 'destroy'])->name('delete');
});


Route::get('/section/{id}' , [InvoiceController::class , 'getProducts'])
 ->middleware(['auth']);


require __DIR__.'/auth.php';


/*

Route::get('/section' , [SectionController::class  , 'index'] )
->middleware(['auth'])->name('section.list');

Route::post('/section/store' , [SectionController::class , 'store'])
->middleware(['auth'])->name('section.store');
/*
Route::put('/section/edit/{id}' , [SectionController::class , 'edit'])
->middleware(['auth'])->name('section.edit');
*/
/*
Route::put('/section/update' , [SectionController::class , 'update'])
->middleware(['auth'])->name('section.update');

Route::delete('/section/delete' , [SectionController::class , 'destroy'])
->middleware(['auth'])->name('section.delete');

*/
