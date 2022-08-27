<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicingReports;



// invoice Reports
Route::group([
    'prefix' => '/reports',
    'as' => 'reports.',
   'middleware' => ['auth' , 'locale'] , 
] , function(){ 
    Route::get('/invoices_report' , [InvoicingReports::class , 'index'])->name('invoices_report');
    Route::get('/search_invoice' , [InvoicingReports::class ,'search_an_invoice'])->name('search_invoice');
});


require __DIR__.'/auth.php';
