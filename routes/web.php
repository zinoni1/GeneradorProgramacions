<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursController;
use App\Http\Controllers\TrimestreController;
use App\Http\Controllers\FestiuController;
use App\Http\Controllers\CicleController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\UfController;
use App\Models\Curs;
use App\Models\Trimestre;
use App\Models\Festiu;

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
Route::get('/error', function () {
    return view('error');
});

Route::resource('curs', CursController::class);
Route::resource('curs.trimestre', TrimestreController::class);
Route::resource('curs.festiu', FestiuController::class);
Route::resource('curs.cicle', CicleController::class);
Route::resource('curs.modul', ModulController::class);
Route::resource('curs.uf', UfController::class);
Route::get('curs/{id}', 'CursController@show')->name('curs.show');


//ruta calendari
Route::get('/calendari', [CursController::class, 'index'])->name('calendari');

Route::get('/dashboard', function () {
    $allcursos = Curs::all();
    $allTrimestres = Trimestre::all();
    $allFestius = Festiu::all();
    $cursos = [];
    foreach ($allcursos as $curs) {
        // Agregar el día de inicio del evento
        $cursos[] = [
            'title' => $curs->nom . ' (Inicio)',
            'start' => $curs->data_inici,
            'color' => '#FF5733',
        ];

        // Agregar el día de fin del evento
        $cursos[] = [
            'title' => $curs->nom . ' (Fin)',
            'start' => $curs->data_final,
            'color' => '#FF5733',
        ];
    }

    foreach ($allTrimestres as $trimestre) {
        // Agregar el día de inicio del evento
        $cursos[] = [
            'title' => $trimestre->nom . ' (Inicio)',
            'start' => $trimestre->data_inici,
            'color' => '#0000FF',
        ];

        // Agregar el día de fin del evento
        $cursos[] = [
            'title' => $trimestre->nom . ' (Fin)',
            'start' => $trimestre->data_final,
            'color' => '#0000FF',
        ];
    }
    foreach ($allFestius as $festiu) {
        // Agregar el día de inicio del evento
        $cursos[] = [
            'title' => $festiu->nom ,
            'start' => $festiu->data_inici,
            'end'   => $festiu->data_final,
            'color' => '#BDECB6',
        ];


    }
    return view('dashboard', compact('cursos'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('export', [CursController::class, 'exportCurs'])->name('curs.export');
require __DIR__.'/auth.php';
