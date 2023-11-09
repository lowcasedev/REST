<?php

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
    return redirect('/auth');
});


Route::middleware('auth')->prefix('auth')->group( function () {
    Route::get('/', function () {
        return view('Auth.auth');
    });
    Route::get('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logOut'])->name('logout');
    Route::match(['get', 'post'], '/login', [App\Http\Controllers\Auth\AuthController::class, 'signIn'])->name('login');
    Route::match(['get', 'post'], '/register', [App\Http\Controllers\Auth\AuthController::class, 'signUp'])->name('register');
});

Route::middleware(['notebook'])->prefix('notebook')->group(function () {
    Route::match(['get', 'delete'],'/', [App\Http\Controllers\Main\MainController::class, 'index']);
    Route::post('/add', [App\Http\Controllers\Main\MainController::class, 'addNote']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Main\MainController::class, 'deleteNote'])->name('delete');
    Route::put('/update/{id}', [App\Http\Controllers\Main\MainController::class, 'updateNote']);
    Route::get('/get/{id}', [App\Http\Controllers\Main\MainController::class, 'getNote']);
});


