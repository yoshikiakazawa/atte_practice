<?php

use App\Http\Controllers\BreakTimeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimestampController;
use App\Http\Controllers\AdminController;

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
    Route::get('/user/{id}', [TimestampController::class, 'user'])->name('user');
});
Route::prefix('admin')->group(function ()
{
    Route::get('login', [AdminController::class, 'login_get'])->name('admin_login_get');
    Route::post('login', [AdminController::class, 'login_post'])->name('admin_login_post');
    Route::get('logout', [AdminController::class, 'logout'])->name('admin_logout');
    Route::patch('update_time', [AdminController::class, 'updateTime'])->name('updateTime');
    Route::patch('update_break', [AdminController::class, 'updateBreak'])->name('updateBreak');
});

Route::prefix('admin')->middleware('auth:admins')->group(function ()
{
    Route::get('/index', [AdminController::class, 'admin'])->name('admin_index');
    Route::get('/user/{id}', [AdminController::class, 'user'])->name('admin_user');
});

Route::get('/login', [TimestampController::class, 'login'])->name('login');
