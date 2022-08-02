<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

/*
Route::get('/invoice', function () {
    return view('invoices.invoices');
})->middleware(['auth'])->name('invoice.list');

*/

Route::group([
    'prefix' => '/invoice',
    'as' => 'invoice.',
    'middleware' => ['auth' , 'locale'],
] , function(){
    Route::get('/' , [InvoiceController::class, 'index'])->name('list');
    Route::post('/store' , [InvoiceController::class , 'store'])->name('store');
    Route::get('/create' , [InvoiceController::class , 'create'])->name('create');
    Route::get('/edit/{invoice}' , [InvoiceController::class , 'edit'])->name('edit');
    Route::put('/update' , [InvoiceController::class , 'update'])->name('update');
    Route::delete('/delete' , [InvoiceController::class , 'destroy'])->name('delete');
    Route::get('/showInvoiceDetails/{id}', [InvoiceDetailController::class , 'show'])->name('show');
    Route::get('/view_file/{invoice_number}/{file_name}', [InvoiceDetailController::class , 'view_file'])->name('view_file');
    Route::get('/download_file/{invoice_number}/{file_name}', [InvoiceDetailController::class , 'download_file'])->name('download_file');
    Route::delete('/delete_file', [InvoiceDetailController::class , 'destroy'])->name('destroy_file');
    Route::post('/add_file', [InvoiceAttachmentController::class , 'store'])->name('add_file');
    Route::get('/status_payment_show/{invoice}' , [InvoiceController::class , 'showStatusPayment'])->name('status_payment_show');
    Route::put('/status_payment_update/{invoice}' , [InvoiceController::class , 'updateStatusPayment'])->name('status_payment_update');
    Route::get('/paid_invoices' , [InvoiceController::class , 'paid_invoices'])->name('paid_invoices');
    Route::get('/unpaid_invoices' , [InvoiceController::class , 'unpaid_invoices'])->name('unpaid_invoices');
    Route::get('/partially_paid_invoices' , [InvoiceController::class , 'partially_paid_invoices'])->name('partially_paid_invoices');
    Route::delete('/archive' , [InvoiceController::class , 'archive_invoice'])->name('archive');
    Route::get('print_invoice/{id}', [InvoiceController::class , 'print_invoice'])->name('print_invoice');


});

 //Route::resource('Archived_invoices'  , ArchiveController::class)->middleware(['auth']);
Route::group([
    'prefix' => '/Archived_invoices',
    'as' => 'Archived_invoices.',
    'middleware' => ['auth' ,  'locale'],
]  , function(){
    Route::get('/' , [ArchiveController::class, 'index'])->name('list');
    Route::put('/update' , [ArchiveController::class, 'update'])->name('update'); // delete archive and move it to invoice list (restore invoice)
    Route::delete('/delete' , [ArchiveController::class , 'destroy'])->name('delete');
});

 Route::get('/section/{id}' , [InvoiceController::class , 'getProducts'])
 ->middleware(['auth']);



require __DIR__.'/auth.php';


/*
Route::get('/invoice', function () {
    return view('invoices.invoices');
})->middleware(['auth'])->name('invoice.list');

*/
