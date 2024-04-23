<?php

use App\Http\Controllers\BreakTimeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimestampController;

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

// Route::resource('', TimestampController::class);

Route::middleware('auth')->group(function ()
{
    Route::get('/', [TimestampController::class, 'index'])->name('index');
    Route::post('/workin', [TimestampController::class, 'workIn'])->name('workIn');
    Route::post('/workout', [TimestampController::class, 'workOut'])->name('workOut');
    Route::post('/breakin', [BreakTimeController::class, 'breakIn'])->name('breakIn');
    Route::post('/breakout', [BreakTimeController::class, 'breakOut'])->name('breakOut');
    Route::get('/attendance', [TimestampController::class, 'attendance'])->name('attendance');
    Route::get('/admin', [TimestampController::class, 'admin'])->name('admin');
    Route::get('/user/{id}', [TimestampController::class, 'user'])->name('user');
});
