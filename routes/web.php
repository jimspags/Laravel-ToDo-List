<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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
    return redirect()->route('todo.index');
});

Route::prefix('todo')->group(function () {
    Route::controller(TodoController::class)->group(function() {
        
        Route::get('/', 'index')->name('todo.index');
        Route::get('/show', 'show')->name('todo.show');
        Route::post('/store', 'store')->name('todo.store');
        Route::delete('/delete/{todo}', 'destroy')->name('todo.delete');
        Route::get('/edit/{todo}', 'edit')->name('todo.edit');
        Route::put('/update/{todo}', 'update')->name('todo.update');
        
    });
});