<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\VideoController;
use App\Http\Livewire\Video\AllVideo;
use App\Http\Livewire\Video\CreateVideo;
use App\Http\Livewire\Video\EditVideo;
use App\Http\Livewire\Video\WatchVideo;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Channel route middleware
    Route::get('/channel/{channel}/edit', [ChannelController::class, 'edit'])->name('channel.edit');

    // Videos route middleware
    Route::get('/videos/{channel}', AllVideo::class)->name('video.all');
    Route::get('/videos/{channel}/create', CreateVideo::class)->name('video.create');
    Route::get('/videos/{channel}/{video}/edit', EditVideo::class)->name('video.edit');
});

Route::get('/watch/{video}', WatchVideo::class)->name('video.watch');
Route::get('/channels/{channel}', [ChannelController::class, 'index'])->name('channel.index');
