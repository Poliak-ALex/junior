<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LinksController;
use App\Http\Controllers\User\LinksController as UserLinksController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/admin/users', UserController::class)->middleware('can:is-admin,user');
Route::get('get-users', [UserController::class, 'getUsers'])->middleware('can:is-admin,user')->name('get-users');

Route::resource('/admin/user/{userId}/links', LinksController::class)->middleware('can:is-admin,user');
Route::get('get-links-admin/{id}', [LinksController::class, 'getLinks'])->middleware('can:is-admin,user')->name('get-links-admin');

Route::get('generate-link', [LinksController::class, 'generateLink'])->name('generate-link');
Route::post('verify-link', [LinksController::class, 'verifyLink'])->name('verify-link');

Route::resource('/user/link', UserLinksController::class);
Route::get('get-links', [UserLinksController::class, 'getLinks'])->name('get-links');

Route::get('/{any}', [LinksController::class, 'forwarding'] );