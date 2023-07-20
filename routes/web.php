<?php

use App\Http\Controllers\DatatableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});



Route::get('/users/list', [DatatableController::class, 'getUsers'])->name('users.list');
// Route::post('/users/order', [DatatableController::class, 'orderUsers'])->name('users.order');
Route::post('/users/delete', [DatatableController::class, 'deleteUser'])->name('users.delete');
