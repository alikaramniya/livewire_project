<?php

use App\Http\Controllers\UserController;
use App\Livewire\Counter;
use App\Livewire\Dropdown;
use App\Livewire\User\Lists;
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
    return view('welcome');
});

Route::get('counter', Counter::class);
Route::get('user/list', Lists::class);
Route::post('user/delete/{user}', Lists::class)->name('user.delete');
Route::get('dropdown', Dropdown::class);

Route::resource('users', UserController::class)->only('index');