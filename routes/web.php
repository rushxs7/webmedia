<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\PingController;
use App\Http\Controllers\WhoisController;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    return Redirect::route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('ping', [PingController::class, 'index'])->name('ping.index');
    Route::post('ping', [PingController::class, 'submit'])->name('ping.submit');
    Route::get('ping/{resulthash}', [PingController::class, 'result'])->name('ping.result');

    Route::get('whois', [WhoisController::class, 'index'])->name('whois.index');
    Route::post('whois', [WhoisController::class, 'submit'])->name('whois.submit');
    Route::get('whois/{resulthash}', [WhoisController::class, 'result'])->name('whois.result');

    Route::get('shortener', [LinkController::class, 'index'])->name('shortener.index');
    Route::post('shortener', [LinkController::class, 'submit'])->name('shortener.submit');
    Route::delete('shortener/{hashid}', [LinkController::class, 'delete'])->name('shortener.delete');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/{hashid}', function($hashid) {
    $link = Link::where('hash', $hashid)->first();
    if (!$link) {
        return abort(404);
    }
    return Redirect::away($link->original_link);
})->name('shortenedurl');
