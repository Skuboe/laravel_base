<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginsController;
use App\Http\Controllers\DiariesController;

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

// ログイン「login」
Route::controller(LoginsController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/execlogin', function () { return redirect('/'); });
    Route::post('/execlogin', 'execlogin');

    Route::get('/account', 'account');
    Route::post('account', 'account');
    Route::get('/regist', function () { return redirect('/account'); });
    Route::post('regist', 'regist');

});
Route::middleware('auth')->controller(LoginsController::class)->group(function () {
    Route::get('/logout', 'logout');
    Route::post('logout', 'logout');
});

// 日記「diary」
Route::middleware('auth')->controller(DiariesController::class)->group(function () {
    Route::get('/diary', 'index');

    Route::get('/create', function () { return redirect('/diary'); });
    Route::post('/create', 'create');

    Route::get('/edit', function () { return redirect('/diary'); });
    Route::post('/edit', 'edit');

    Route::get('/delete', function () { return redirect('/diary'); });
    Route::post('/delete', 'delete');
});
