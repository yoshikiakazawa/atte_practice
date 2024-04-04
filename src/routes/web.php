<?php

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
    Route::get('/', [TimestampController::class, 'index']);
    Route::post('/workin', [TimestampController::class, 'workin']);
    Route::post('/workout', [TimestampController::class, 'workout']);
    Route::post('/breakin', [TimestampController::class, 'breakin']);
    Route::post('/breakout', [TimestampController::class, 'breakout']);
});
