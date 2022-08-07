<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   // return view('welcome');
   return redirect('/login');
});

Route::get('/test',  [InvoiceController::class , 'test']);


Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth' ,  'locale'])->name('dashboard');


/*
Route::get('/invoice', function () {
    return view('invoices.invoices');
})->middleware(['auth'])->name('invoice.list');
*/
/*
Route::get('/home', function () {
    return view('index');
})->middleware(['auth'])->name('home');
*/

Route::get('/mod', function () {
    return view('modals');
})->middleware(['auth' ,  'locale'])->name('home');


require __DIR__.'/auth.php';
require __DIR__.'/invoice.php';
require __DIR__.'/section.php';
require __DIR__.'/product.php';
require __DIR__.'/roles.php';
require __DIR__.'/users.php';

