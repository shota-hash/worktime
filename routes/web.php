<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\WorkController;

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

Route::get('/', [WorkController::class, 'index'])->middleware(['auth']);
//Route::get('/', function () {
    //return view('welcome');
//});
//出退勤打刻
Route::post('/workin', [WorkController::class, 'workIn'])->name('workin');
Route::post('/workout', [WorkController::class, 'workOut'])->name('workout');
//休憩打刻
Route::post('/restin', [WorkController::class, 'restIn'])->name('restin');
Route::post('/restout', [WorkController::class, 'restOut'])->name('restout');
//Route::get('/dashboard', function () {
    //return view('dashboard');
//})->middleware(['auth'])->name('dashboard');
Route::get('/attendance', [WorkController::class, 'show']);

require __DIR__.'/auth.php';
