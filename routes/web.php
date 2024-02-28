<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursController;
use App\Http\Controllers\TrimestreController;
use App\Http\Controllers\FestiuController;

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

//TODO El curs ha de estar validat amb auth y nomes pot admin
//Route::resource('curs', CursController::class);

Route::resource('curs', CursController::class);
Route::resource('error', CursController::class);
Route::resource('trimestre', TrimestreController::class);
Route::resource('festiu', FestiuController::class);
Route::resource('cicle', CicleController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('export', [CursController::class, 'exportCurs'])->name('curs.export');
require __DIR__.'/auth.php';
